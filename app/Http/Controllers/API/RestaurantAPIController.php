<?php

namespace App\Http\Controllers\API;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\FoodType;

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
            'address' => $restaurant->addresses()->get(['address', 'latitude', 'longitude'])->first(),
            // TODO:uncomment phone
            // 'phone' => $restaurant->phone,
            'is_open' => $restaurant->status == 'active' ? true : false,
            'image' => $restaurant->image->path,
            'score' => number_format($restaurant->comments()->avg('score'), 2),
            ];
        });

        if (isset($request['score_gt'])) {
            $restaurants = $restaurants->filter(function ($restaurant) use ($request) {
                return $restaurant['score'] >= $request['score_gt'] ?? 0
                && $restaurant['score'] <= $request['score_lt'] ?? 5;
            });
        }

        if ($restaurants->isEmpty()) {
            return response(
            ['msg' => 'No restaurants found'], 404);
        }

        return response($restaurants);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $restaurant = Restaurant::where([['id', $id], ['confirm', 'accept']])->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'restaurant not found'], 404);
        }

        $days = ['saturday' => 1, 'sunday' => 2, 'monday' => 3, 'tuesday' => 4, 'wednesday' => 5, 'thursday' => 6, 'friday' => 7];
        $restaurant = [
            'id' => $restaurant->id,
            'title' => $restaurant->title,
            'type' => $restaurant->foodType->name,
            'address' => $restaurant->addresses()->get(['address', 'latitude', 'longitude'])->first(),
            // TODO:uncomment phone
            // 'phone' => $restaurant->phone,
            'is_open' => $restaurant->status == 'active' ? true : false,
            'image' => $restaurant->image->path ? $restaurant->image->path : null,
            'score' => number_format($restaurant->comments()->avg('score'), 2),
            'comment_count' => $restaurant->comments()->count(),
            'schedule' => $restaurant->weekSchedules->keyBy('day')->map(function ($item) {
            return [
            'start' => $item->open_time,
            'end' => $item->close_time
            ];
        })
        ];

        // for add null if no schedule for that day
        collect($days)->diffKeys($restaurant['schedule'])->each(function ($item, $key) use ($restaurant) {
            $restaurant['schedule'][$key] = null;
        });
        // sort by day order in week schedule
        $restaurant['schedule'] = $restaurant['schedule']->sortBy(fn($val, $key) => $days[$key]);

        return response($restaurant, 200);
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
        $foods = $this->createFormat($foods);
        return response($foods);
    }

    public function createFormat($foods)
    {
        $foods = $foods->map(function ($food) {
            $item['id'] = $food->id;
            $item['title'] = $food->name;
            $item['price'] = $food->price;

            if ($food->discount != null && $food->discount != 0) {
                $item['off'] = ['label' => $food->discount . '%', 'factor' => 1 - $food->discount / 100];
            }
            //if have food party discount ignored
            if ($food->foodParty != null) {
                $item['off'] = ['label' => $food->foodParty->name, 'factor' => 1 - $food->foodParty->discount / 100];
            }

            $item['raw_material'] = $food->rawMaterials->implode('name', ', ');
            $item['image'] = $food->image ? $food->image->path : null;
            $item['food_type_id'] = $food->food_type_id;

            return $item;

        })
            ->groupBy('food_type_id')->map(function ($food, $index) {
            $item['id'] = $index;
            $item['title'] = FoodType::find($index)->name;
            $item['foods'] = $food;
            return $item;
        })
            ->sortBy(['title', 'asc'])->values();
        ;
        return $foods;
    }
}
