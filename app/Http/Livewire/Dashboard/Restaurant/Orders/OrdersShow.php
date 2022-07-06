<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Orders;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class OrdersShow extends Component
{
    public $restaurant;
    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function changeStatus($cartId, $status)
    {
        $cart = Cart::find($cartId);
        $cart->status = $status + 1;
        $cart->update();
        $this->emitSelf('refreshComponent');
    }

    public function fetchData()
    {
        $this->carts = Cart::where('restaurant_id', $this->restaurant->id)->get()->map(function ($cart) {
            $cart->food = $cart->cartFood;
            return $cart;
        });
    }

    public function render()
    {
        $this->fetchData();
        return view('livewire.dashboard.restaurant.orders.orders-show');
    }
}
