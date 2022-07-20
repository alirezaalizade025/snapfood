<?php

namespace App\Http\Livewire\Customer\Category\Restaurant;

use App\Models\Food;
use Livewire\Component;
use App\Models\Restaurant;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RestaurantAPIController;

class ShowFoods extends Component
{
    public $restaurant;

    public function addToCart($id)
    {
        $this->emit('addItemToCart', $id);
    }

    public function fetchData()
    {
        $response = app(RestaurantAPIController::class)->foods($this->restaurant->id);

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
