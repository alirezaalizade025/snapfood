<?php

namespace App\Http\Livewire\Customer\Cart;

use App\Models\Food;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


class SideCart extends Component
{
    public $restaurant;
    public $total_price;
    public $carts;
    protected $listeners = [
        'addItemToCart',
        'refreshComponent' => '$refresh'
    ];

    public function increaseCount($id)
    {
        $request = Request::create('/api/carts/add', 'PATCH', ['food_id' => $id, 'count' => 1]);
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Authorization', 'Bearer ' . '1|GheIVySS3mXtw3vte0GX3b1ZcsxM2wnoSvnfGHq6');

        $response = Route::dispatch($request);

        if ($response->status() == 200) {
            $this->emit('refreshComponent');
        }
        else {
        // TODO:show message
        }
    }

    public function decreaseCount($id)
    {
        $request = Request::create('/api/carts/decrease', 'PATCH', ['food_id' => $id, 'count' => 1]);
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Authorization', 'Bearer ' . '1|GheIVySS3mXtw3vte0GX3b1ZcsxM2wnoSvnfGHq6');

        $response = Route::dispatch($request);
        if ($response->status() == 200) {
            $this->emit('refreshComponent');
        }
        else {
        // TODO:show message
        }
    }

    public function addItemToCart($id)
    {

        if (auth()->check()) {
            $request = Request::create('/api/carts/add', 'POST', ['food_id' => $id, 'count' => 1]);
            $request->headers->set('Accept', 'application/json');
            $request->headers->set('Authorization', 'Bearer ' . '1|GheIVySS3mXtw3vte0GX3b1ZcsxM2wnoSvnfGHq6');

            $response = Route::dispatch($request);
            if ($response->status() == 200) {
                $this->emit('refreshComponent');
            }
            else {
            // TODO:show message
            }
        }
        else {
            redirect()->route('login');
        }
    }

    public function fetchData()
    {
        $request = Request::create('/api/carts/restaurant/' . $this->restaurant->id, 'GET');
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Authorization', 'Bearer ' . '1|GheIVySS3mXtw3vte0GX3b1ZcsxM2wnoSvnfGHq6');
        $response = Route::dispatch($request);
        if ($response->status() == 200) {
            $response = collect(json_decode($response->getContent())->data)->first();
            if ($response) {
                $this->total_price = collect($response->foods)->sum('price');
                $this->total_count = collect($response->foods)->sum('count');
            }
        }
        else {
            $response = false;
        }

        return (array)$response;
    }

    public function render()
    {
        $this->carts = $this->fetchData();
        return view('livewire.customer.cart.side-cart');
    }
}
