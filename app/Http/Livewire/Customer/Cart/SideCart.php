<?php

namespace App\Http\Livewire\Customer\Cart;

use App\Models\Food;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CartController;
use WireUi\Traits\Actions;


class SideCart extends Component
{
    use Actions;
    public $restaurant;
    public $total_price;
    public $carts;
    protected $listeners = [
        'addItemToCart',
        'refreshComponent' => '$refresh'
    ];

    public function increaseCount($id)
    {
        $request = new Request(['cart_id' => $this->carts['id'], 'food_id' => $id, 'count' => 1]);
        $response = app('App\Http\Controllers\API\CartController')->update($request);

        if ($response->status() == 200) {
            $this->emit('refreshComponent');
        }
        else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = json_decode($response->getContent())->msg
            );
        }
    }

    public function decreaseCount($id)
    {
        $request = new Request(['cart_id' => $this->carts['id'], 'food_id' => $id, 'count' => 1]);
        $response = app('App\Http\Controllers\API\CartController')->decrease($request);
        if ($response->status() == 200) {
            $this->emit('refreshComponent');
        }
        else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = json_decode($response->getContent())->msg
            );
        }
    }

    public function addItemToCart($id)
    {

        if (auth()->check()) {
            $request = new Request(['food_id' => $id, 'count' => 1]);
            $response = app(CartController::class)->store($request);
            if ($response->status() == 200) {
                $this->emit('refreshComponent');
            }
            else {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = json_decode($response->getContent())->msg
                );
            }
        }
        else {
            redirect()->route('login');
        }
    }

    public function fetchData()
    {
        $request = new Request(['restaurant_id' => $this->restaurant->id]);
        $response = app('App\Http\Controllers\API\CartController')->userCartByRestaurant($request);
        if ($response->status() == 200) {
            $response = collect(json_decode($response->getContent())->data)->first();
            if (optional($response)->foods) {
                $this->total_price = collect($response->foods)->sum('price');
                $this->total_final_price = collect($response->foods)->sum('final_price');
                $this->total_count = collect($response->foods)->sum('count');
            }
        }
        else {
            $response = false;
        }
        return collect($response);
    }

    public function render()
    {
        $this->carts = $this->fetchData();
        return view('livewire.customer.cart.side-cart');
    }
}
