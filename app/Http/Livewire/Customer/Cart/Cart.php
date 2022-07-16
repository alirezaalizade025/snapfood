<?php

namespace App\Http\Livewire\Customer\Cart;

use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Controllers\API\CartController;

class Cart extends Component
{
    use Actions;
    public $carts;
    public function increase($food_id, $cart_id)
    {
        $request = new Request(['cart_id' => $cart_id, 'food_id' => $food_id, 'count' => 1]);
        $response = app(CartController::class)->update($request);

        if ($response->status() == 200) {
            $this->fetchData();
        }
        else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = json_decode($response->getContent())->msg
            );
        }
    }
    public function decrease($food_id, $cart_id)
    {
        $request = new Request(['cart_id' => $cart_id, 'food_id' => $food_id, 'count' => 1]);
        $response = app(CartController::class)->decrease($request);
        if ($response->status() == 200) {
            $this->fetchData();
        }
        else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = json_decode($response->getContent())->msg
            );
        }
    }
    /**
     * Remove by CartFood ID
     *
     * @param $id
     * @return void
     */
    public function remove($cart_id, $food_id)
    {
        $request = new Request(['cart_id' => $cart_id, 'food_id' => $food_id]);
        $response = app('App\Http\Controllers\API\CartController')->removeFromCart($request);
        if ($response->status() == 200) {
            $this->fetchData();
        }
        else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = json_decode($response->getContent())->msg
            );
        }
    }

    public function reorder($id)
    {
        $response = app('App\Http\Controllers\API\CartController')->reorder($id);
        if ($response->status() == 200) {
            $this->fetchData();
        }
        else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = json_decode($response->getContent())->msg
            );
        }
    }

    public function fetchData()
    {
        $request = new Request(['user_id' => auth()->id()]);
        $response = app('App\Http\Controllers\API\CartController')->index($request);
        if ($response->status() == 200) {
            $this->carts = collect(json_decode($response->getContent())->carts);
            $this->carts->map(function ($cart) {
                $cart->total = collect($cart->foods)->sum('total_price');
                return $cart;
            })->groupBy('status');
        }
        else {
            $this->carts = [];
        }
    }

    public function render()
    {
        $this->fetchData();
        return view('livewire.customer.cart.cart');
    }
}
