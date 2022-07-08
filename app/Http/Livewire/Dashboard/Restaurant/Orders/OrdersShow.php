<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Orders;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class OrdersShow extends Component
{
    public $restaurant;
    public $search;
    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function changeStatus($cartId, $status)
    {
        $cart = Cart::find($cartId);
        if ($cart->status != 4) {
            $cart->status = $status + 1;
            $cart->update();
            $this->emitSelf('refreshComponent');
        }
    }

    public function fetchData()
    {
        // TODO: fetch data from api
        // TODO:add filter to blade and php
        $where = [];
        if ($this->search != null) {
            $where[] = ['id', $this->search];
        }
        $this->carts = Cart::where('restaurant_id', $this->restaurant->id)->where($where)->get()->map(function ($cart) {
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