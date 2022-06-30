<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantShowResource;
use App\Http\Resources\RestaurantFoodsResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RestaurantAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::filter($request)
            ->get()
            ->map(function ($restaurant) {
            return [
            'id' => $restaurant->id,
            'title' => $restaurant->title,
            'type' => $restaurant->category->map(function ($item) {
                    return $item->category->name;
                }
                )->implode(', '),
                'address' => $restaurant->addressInfo()->get(['address', 'latitude', 'longitude'])->first(),
                // 'phone' => $restaurant->phone, // TODO:uncomment phone
                'is_open' => $restaurant->status == 'active' ? true : false,
                'image' => isset($restaurant->image) ? $restaurant->image->path : null,
                'score' => $restaurant->carts->map(fn($cart) => $cart->comments->avg('score'))->avg(),
                ];
            });

        if (isset($request['score_gt'])) {
            $restaurants = $restaurants->filter(function ($restaurant) use ($request) {
                return $restaurant['score'] >= $request['score_gt'] ?? 0;
            })->values();
        }

        if (isset($request['category_id'])) {
            $category = Category::find($request['category_id']);
            if (isset($category)) {
                $restaurants = $restaurants->filter(function ($restaurant) use ($request, $category) {
                    $pattern = "/$category->name/";
                    return preg_match($pattern, $restaurant['type']);
                })->values();
            }
            else {
                return response(
                ['msg' => 'No category found'], 404);
            }
        }
        // TODO:refactor category filter


        if ($restaurants->isEmpty()) {
            return response(
            ['msg' => 'No restaurants found'], 404);
        }

        return response(['data' => $restaurants]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $restaurant = Restaurant::where([['id', $id], ['confirm', 'accept']])->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'restaurant not found'], 404);
        }
        $restaurant = RestaurantShowResource::collection([$restaurant])->first();

        return response()->json($restaurant, 200);
    }

    public function foods($id)
    {
        try {
            $restaurant = Restaurant::where([['id', $id], ['confirm', 'accept']])->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'restaurant not found'], 404);
        }

        $foods = $restaurant
            ->foods()
            ->get();
        return ['data' => RestaurantFoodsResource::collection($foods)->
            groupBy('category_id')->map(function ($food, $index) {
            $item['id'] = $index;
            $item['title'] = Category::find($index)->name;
            $item['foods'] = $food;
            return $item;
        })
            ->sortBy(['title', 'asc'])->values()];
        ;
    }

// public function createFormat($foods)
// {
//     $foods = $foods->map(function ($food) {
//         $item['id'] = $food->id;
//         $item['title'] = $food->name;
//         $item['price'] = $food->price;

//         if ($food->discount != null && $food->discount != 0) {
//             $item['off'] = ['label' => $food->discount . '%', 'factor' => 1 - $food->discount / 100];
//         }
//         //if have food party discount ignored
//         if ($food->foodParty != null) {
//             $item['off'] = ['label' => $food->foodParty->name, 'factor' => 1 - $food->foodParty->discount / 100];
//         }

//         $item['raw_material'] = $food->rawMaterials->implode('name', ', ');
//         $item['image'] = $food->image ? $food->image->path : null;
//         $item['category_id'] = $food->category_id;

//         return $item;

//     })
//         ->groupBy('category_id')->map(function ($food, $index) {
//         $item['id'] = $index;
//         $item['title'] = Category::find($index)->name;
//         $item['foods'] = $food;
//         return $item;
//     })
//         ->sortBy(['title', 'asc'])->values();
//     ;
//     return $foods;
// }
}
