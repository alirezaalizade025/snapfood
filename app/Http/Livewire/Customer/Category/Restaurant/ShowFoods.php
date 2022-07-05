<?php

namespace App\Http\Livewire\Customer\Category\Restaurant;

use App\Models\Food;
use Livewire\Component;
use App\Models\Restaurant;

class ShowFoods extends Component
{
    public $restaurant;

    public function addToCart($id)
    {
        $this->emit('addItemToCart', $id);
    }

    public function fetchData()
    {
        $restaurant = Restaurant::
            where([['confirm', 'accept']])
            ->find($this->restaurant->id);
        if ($restaurant) {
            return ($restaurant->foods->groupBy('category_id')->map(function ($category) {
                $category->map(function($food) {
                    if (isset($food->food_type_id)) {
                        $food->final_price = $food->price * (1 - $food->foodParty->discount / 100);
                    }
                    elseif (isset($food->discount)) {
                        $food->final_price = $food->price * (1 - $food->discount / 100);
                    }
                    else {
                        $food->final_price = $food->price;
                    }
                    return $food;
                });
                $category->title = $category->first()->category->name;
                return $category;
            }));
        }
        else {
            return abort(404);
        }

    }

    public function render()
    {
        return view('livewire.customer.category.restaurant.show-foods', [
            'categories' => $this->fetchData()
        ]);
    }
}
