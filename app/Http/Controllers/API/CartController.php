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
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($carts->count() > 0) {
            $this->authorize('view', $carts->first());
        }

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
        $this->authorize('create', Cart::class);
        if (auth()->user()->role != 'customer') {
            return response(['msg' => 'Only Customer can order cart!'], 404);
        }
        try {
            $food = Food::findOrFail($request->food_id);
            if ($food->restaurant->status == 'inactive') {
                return response(['msg' => 'Restaurant not active'], 404);
            }
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Food not found'], 404);
        }
        $cart = Cart::where([['user_id', auth()->id()], ['status', '0'], ['restaurant_id', $food->restaurant_id]])
            ->firstOrCreate(
        ['user_id' => auth()->user()->id],
        ['restaurant_id' => $food->restaurant_id],
        ['cart_number' => 1],
        );


        $foodWithDiscount = isset($food->food_party_id) ? (1 - $food->foodParty->discount / 100) * $food->price : (isset($food->discount) ? (1 - $food->discount / 100) * $food->price : $food->price);

        $cartFood = CartFood::where(['cart_id' => $cart->id, 'food_id' => $food->id])->get()->first();
        if ($cartFood) {
            $cartFood->quantity += $request->count;
            $cartFood->price = $foodWithDiscount * $cartFood->quantity;
            $cartFood->save();
        }
        else {
            $cartFood = new CartFood();
            $cartFood->cart_id = $cart->id;
            $cartFood->food_id = $food->id;
            $cartFood->quantity = $request->count;
            $cartFood->price = $foodWithDiscount * $cartFood->quantity;
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

        if ($carts->count() > 0) {
            $this->authorize('view', $carts->first());
        }

        $carts = CartResource::collection($carts);

        return response(['data' => $carts]);
    }

    /**
     * Update(increase) the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (auth()->user()->role != 'customer') {
            return response(['msg' => 'Only Customer can order cart!'], 404);
        }
        try {
            $food = Food::findOrFail($request->food_id);
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Food not found'], 404);
        }
        if (!$request->has('cart_id')) {
            $cart = Cart::where([['user_id', auth()->id()], ['status', '0'], ['restaurant_id', $food->restaurant_id]])
                ->get()->first();
        }
        else {
            $cart = Cart::where([['user_id', auth()->id()], ['id', $request->cart_id], ['restaurant_id', $food->restaurant_id]])
                ->firstOrCreate(
            ['user_id' => auth()->user()->id],
            ['restaurant_id' => $food->restaurant_id],
            ['cart_number' => 1],
            );
        }

        $this->authorize('update', $cart);

        $foodWithDiscount = isset($food->food_party_id) ? (1 - $food->foodParty->discount / 100) * $food->price : (isset($food->discount) ? (1 - $food->discount / 100) * $food->price : $food->price);


        try {
            $cartFood = CartFood::where('cart_id', $cart->id)->where('food_id', $food->id)->get()->first();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Cart not found'], 404);
        }

        if ($cartFood) {
            $cartFood->quantity += $request->count;
            $cartFood->price = $foodWithDiscount * $cartFood->quantity;
            $cartFood->save();
            return response(['msg' => 'Food Updated to cart successfully', 'cart_id' => $cart->id]);
        }
        return response(['msg' => 'Cart not found'], 404);
    }

    /**
     * Update(decrease) the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function decrease(Request $request)
    {
        try {
            $food = Food::findOrFail($request->food_id);
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Food not found'], 404);
        }
        if (!$request->has('cart_id')) {
            $cart = Cart::where([['user_id', auth()->id()], ['status', '0'], ['restaurant_id', $food->restaurant_id]])
                ->get()->first();
        }
        else {
            $cart = Cart::where([['user_id', auth()->id()], ['id', $request->cart_id], ['restaurant_id', $food->restaurant_id]])
                ->firstOrCreate(
            ['user_id' => auth()->user()->id],
            ['restaurant_id' => $food->restaurant_id],
            ['cart_number' => 1],
            );
        }

        $this->authorize('update', $cart);

        $foodWithDiscount = isset($food->food_party_id) ? (1 - $food->foodParty->discount / 100) * $food->price : (isset($food->discount) ? (1 - $food->discount / 100) * $food->price : $food->price);


        try {
            $cartFood = $cart->cartFood()->where('food_id', $food->id)->get()->first();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'Cart not found'], 404);
        }

        if ($cartFood) {
            if ($cartFood->quantity > 1) {
                $cartFood->quantity -= $request->count;
                $cartFood->price = $foodWithDiscount * $cartFood->quantity;
                $cartFood->save();
            }
            else {
                $cartFood->delete();
                $cartFood = CartFood::where('cart_id', $cart->id)->get();

                if (CartFood::where('cart_id', $request->cart_id)->get()->count() == 0) {
                    $cart->forceDelete();
                }

                return response(['msg' => 'Food remove from cart successfully', 'cart_id' => $cart->id]);

            }
            return response(['msg' => 'Food Updated on cart successfully', 'cart_id' => $cart->id]);
        }
        return response(['msg' => 'Cart not found'], 404);
    }

    public function sendToPay(Request $request, $cartID)
    {
        $cart = Cart::
            where('user_id', auth()->id())
            ->where('id', $request->cart_id)
            ->get()->first();
        if (!$cart) {
            return response(['msg' => 'Cart not found'], 404);
        }
        $this->authorize('update', $cart);

        $restaurant = $cart->restaurant;
        //check for open time
        
        if ($restaurant->weekSchedules->count() > 0) {
            $weekSchedules = $restaurant->weekSchedules()->where('day', now()->dayOfWeek + 2)->get()->first();  
            if ($weekSchedules != null && now()->addMinutes('270')->format('H:i') >= $weekSchedules->start && now()->addMinutes('270')->format('H:i') <= $weekSchedules->end) {
                if ($restaurant->status == 'inactive') {
                    return response()->json(['msg' => 'Restaurant is closed'], 403);
                }
            }
            else {
                return response()->json(['msg' => 'Restaurant is closed'], 403);
                ;
            }
        }
        else {
            return response()->json(['msg' => 'Restaurant is closed'], 403);
        }


        $cart->status = "1";
        $cart->save();

        // $cart = CartResource::collection($cart);
        return response(['msg' => 'cart sending to pay page', 'cart' => $cartID]);
    }

    public function userCartByRestaurant(Request $request)
    {
        $carts = Cart::
            where('user_id', auth()->id())
            ->where('restaurant_id', $request->restaurant_id)
            ->where('status', '0')
            ->get();

        if (empty($carts)) {
            return response([]);
        }

        if ($carts->count()) {
            $this->authorize('userCartByRestaurant', $carts->first());
        }

        $carts = CartResource::collection($carts);

        return response(['data' => $carts]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $this->authorize('update', $cart);

        $cartFood = CartFood::where([['cart_id', $request->cart_id], ['food_id', $request->food_id]])->get()->first();
        if (!$cartFood) {
            return response(['msg' => 'Cart not found'], 404);
        }

        $cartFood->delete();

        $cartFood = CartFood::where('cart_id', $cart->id)->get();

        if (CartFood::where('cart_id', $request->cart_id)->get()->count() == 0) {
            $cart->forceDelete();
        }
        return response(['msg' => 'Food remove from cart successfully', 'cart_id' => $cart->id]);
    }

    public function reorder($id)
    {
        $cart = Cart::where('user_id', auth()->id())->find($id);

        foreach ($cart->cartFood as $cartFood) {
            $response = $this->store(new Request(['food_id' => $cartFood->food_id, 'count' => $cartFood->quantity]));
            if ($response->status() != 200) {
                return $response;
            }
        }
        return $response;

    }
}
