<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Image;
use App\Models\CartFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::
            where('user_id', auth()->id())
            ->get();

        $carts = CartResource::collection($carts);

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
        try {
            $food = Food::findOrFail($request->food_id);
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Food not found'], 404);
        }
        $cart = Cart::where([['user_id', auth()->id()], ['cart_number', 1]])->firstOrCreate(
        ['user_id' => auth()->user()->id],
        ['cart_number' => 1]
        );

        $foodWhitDiscount = isset($food->food_party_id) ? (1 - $food->foodParty->discount / 100) * $food->price : (isset($food->discount) ? (1 - $food->discount / 100) * $food->price : $food->price);

        $cartFood = CartFood::where(['cart_id' => $cart->id, 'food_id' => $food->id])->get()->first();
        if ($cartFood) {
            $cartFood->quantity += $request->count;
            $cartFood->price = $foodWhitDiscount * $cartFood->quantity;
            $cartFood->save();
        }
        else {
            $cartFood = new CartFood();
            $cartFood->cart_id = $cart->id;
            $cartFood->food_id = $food->id;
            $cartFood->quantity = $request->count;
            $cartFood->price = $foodWhitDiscount * $cartFood->quantity;
            $cartFood->save();
        }

        return response(['msg' => 'Food added to cart successfully', 'cart_id' => $cart->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $carts = Cart::
            where('user_id', auth()->id())
            ->where('id', $request->cart_id)
            ->get();

        $carts = CartResource::collection($carts);

        return response(['data' => $carts]);
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
        // TODO: destroy cart implement in destroy
        try {
            $food = Food::findOrFail($request->food_id);
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Food not found'], 404);
        }

        $cart = Cart::where('cart_number', 1)->where('user_id', auth()->user()->id)->get()->first();
        $foodWhitDiscount = isset($food->food_party_id) ? (1 - $food->foodParty->discount / 100) * $food->price : (isset($food->discount) ? (1 - $food->discount / 100) * $food->price : $food->price);


        try {
            $cartFood = CartFood::where('cart_id', $cart->id)->where('food_id', $food->id)->get()->first();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Cart not found'], 404);
        }

        if ($cartFood) {
            if ($request->count > 0) {
                $cartFood->quantity = $request->count;
                $cartFood->price = $foodWhitDiscount * $cartFood->quantity;
                $cartFood->save();
            }
            else {
                $cartFood->delete();
                return response(['msg' => 'Food remove from cart successfully', 'cart_id' => $cart->id]);

            }
            return response(['msg' => 'Food Updated to cart successfully', 'cart_id' => $cart->id]);
        }
        return response(['msg' => 'Cart not found'], 404);
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

    public function sendToPay(Request $request, $cartID)
    {
        $cart = $this->cartFormatter($request->cart_id);

        return response(['msg' => 'cart sending to pay page', 'cart' => $cart]);
    }
}
