<?php

namespace App\Http\Livewire\Customer\Category\Restaurant;

use App\Models\Food;
use Livewire\Component;
use App\Models\Restaurant;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

class ShowFoods extends Component
{
    public $restaurant;

    public function addToCart($id)
    {
        $this->emit('addItemToCart', $id);
    }

    public function fetchData()
    {
        $request = Request::create('/api/restaurants/' . $this->restaurant->id . '/foods', 'GET');
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Authorization', 'Bearer ' . auth()->user()->api_token);

        $response = Route::dispatch($request);
        if ($response->status() == 200) {
            $foodByCategory = json_decode($response->getContent())->data;
        }

        if (isset($foodByCategory)) {
            return $foodByCategory;
        }

    }

    public function render()
    {
        return view('livewire.customer.category.restaurant.show-foods', [
            'categories' => $this->fetchData()
        ]);
    }
}
