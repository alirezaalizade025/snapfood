<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::join('cart_users', 'cart_users.cart_id', '=', 'carts.id')
            ->join('food', 'food.id', '=', 'cart_users.food_id')
            ->join('restaurants', 'restaurants.id', '=', 'food.restaurant_id')
            ->join('users', 'users.id', '=', 'carts.user_id')
            ->where('carts.user_id', auth()->user()->id)
            ->select(
            'carts.id as cart_id',
            // 'carts.status as cart_status', //TODO:uncomment
            'food.id as food_id',
            'food.name as food_name',
            'restaurants.id as restaurant_id',
            'restaurants.title as restaurant_title',
            'cart_users.quantity as count',
            'cart_users.price as price',
        )
            ->get()
            ->groupBy('restaurant_id')
            ->values()
            ->map(function ($item) {
            $result['id'] = $item->first()->cart_id;
            $result['restaurant'] = [
                'title' => $item->first()->restaurant_title,
                'image' => Image::where('imageable_id', $item->first()->restaurant_id)->where('imageable_type', 'App\Models\Restaurant')->first() ?Image::where('imageable_id', $item->first()->restaurant_id)->where('imageable_type', 'App\Models\Restaurant')->first()->path : null,
            ];
            $result['foods'] = $item->map(function ($item) {
                    return [
                    'id' => $item->food_id,
                    'title' => $item->food_name,
                    'count' => $item->count,
                    'price' => $item->price,
                    // 'image' => Image::where('imageable_id', $item->food_id)->where('imageable_type', 'App\Models\Food')->first() ? Image::where('imageable_id', $item->food_id)->where('imageable_type', 'App\Models\Food')->first()->path : null //TODO: uncomment
                    ];
                }
                );
                return $result;
            })
            ->values()
            ;
        return response(compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
    //
    }
}
