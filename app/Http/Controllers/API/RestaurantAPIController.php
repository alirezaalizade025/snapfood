<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantShowResource;
use App\Http\Resources\RestaurantFoodsResource;
use App\Http\Resources\RestaurantIndexResource;
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
        $userAddress = auth()->user()->addresses()->where('is_current_location', true)->get()->first();

        //filters
        $where[] = ['restaurants.confirm', 'accept'];
        if ($request->has('score_gt')) {
            $where[] = ['score', '>=', $request->score_gt];
        }
        ;
        if ($request->has('type')) {
            $where[] = ['categories.category_id', $request->type];
        }
        ;
        if ($request->has('is_open')) {
            $where[] = ['restaurants.status', true];
        }
        ;

        //find full details
        $restaurants = Restaurant::
            join('category_restaurants', 'category_restaurants.restaurant_id', '=', 'restaurants.id')
            ->join('categories', 'categories.id', '=', 'category_restaurants.category_id')
            ->join('addresses', 'addresses.addressable_id', '=', 'restaurants.id')
            ->join('carts', 'carts.restaurant_id', '=', 'restaurants.id')
            ->join('comments', 'comments.cart_id', '=', 'carts.id')
            ->with('category')
            ->select(
            'restaurants.*',
            DB::raw('AVG(comments.score) AS score'),
            'addresses.latitude',
            'addresses.longitude',
            "addresses.id as address_id",
            DB::raw("6371 * acos(cos(radians(" . $userAddress['latitude'] . ")) * cos(radians(addresses.latitude)) * cos(radians(addresses.longitude) - radians(" . $userAddress['longitude'] . ")) + sin(radians(" . $userAddress['latitude'] . ")) * sin(radians(addresses.latitude))) AS distance"),
        )
            ->having('distance', '<', 5000) //TODO:fix this km
            ->where('restaurants.confirm', 'accept')
            ->where($where)
            ->groupBy('addresses.id')
            ->groupBy('restaurants.id')
            ->orderBy('distance', 'asc')
            ->get();

        $restaurants = RestaurantIndexResource::collection($restaurants);
        
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function showForDashboard($id)
    {
        try {
            $restaurant = Restaurant::where([['id', $id]])->firstOrFail();
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

        $foods = $restaurant->foods()->where('status', 1)->get();

        return response(['data' => RestaurantFoodsResource::collection($foods)->
            groupBy('category_id')->map(function ($food, $index) use($restaurant) {
            $item['id'] = $index;
            $item['title'] = Category::find($index)->name;
            $item['delivery_fee'] = $restaurant->delivery_fee;
            $item['foods'] = $food;
            return $item;
        })
            ->sortBy(['title', 'asc'])->values()]);
        ;
    }

}
