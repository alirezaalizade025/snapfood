<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;

class ShowRestaurants extends Component
{
    public $category;
    public $sortBy = 'distance';
    public $search;

    public function getRestaurants()
    {
        $where = [];
        if ($this->search) {
            $where[] = ['restaurants.title', 'like', '%' . $this->search . '%'];
        }
        return (
            Restaurant::
            join('category_restaurants', 'category_restaurants.restaurant_id', '=', 'restaurants.id')
            ->join('categories', 'categories.id', '=', 'category_restaurants.category_id')
            ->join('addresses', 'addresses.addressable_id', '=', 'restaurants.id')
            ->join('cart_restaurant', 'cart_restaurant.restaurant_id', '=', 'restaurants.id')
            ->join('comments', 'comments.cart_id', '=', 'cart_restaurant.cart_id')
            ->select(
            'restaurants.*'
            , DB::raw('AVG(comments.score) AS rating'),
            'addresses.latitude',
            'addresses.longitude',
            "addresses.id as address_id",
            DB::raw("6371 * acos(cos(radians(" . 4.639 . ")) * cos(radians(addresses.latitude)) * cos(radians(addresses.longitude) - radians(" . 53.822 . ")) + sin(radians(" . 4.639 . ")) * sin(radians(addresses.latitude))) AS distance"),
        )
            ->having('distance', '<', 5)
            ->where('category_restaurants.category_id', $this->category->id)
            ->where('categories.id', $this->category->id)
            ->where($where)
            ->groupBy('addresses.id')
            ->orderBy($this->sortBy, 'asc')
            ->paginate(10)
            );
    }

    public function render()
    {
        return view('livewire.category.show-restaurants', [
            'restaurants' => $this->getRestaurants(),
        ]);
    }
}
