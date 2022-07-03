<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ShowRestaurants extends Component
{
    use WithPagination;

    public $category;
    public $sortBy = 'distance';
    public $search;
    public $subCategory;
    public $listeners = [
        'changeSubCategory'
    ];

    public function changeSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;
    }


    public function getRestaurants($subCategory = null)
    {
        $where = [];

        if ($this->search) {
            $where[] = ['restaurants.title', 'like', '%' . $this->search . '%'];
        }

        $subCategory = isset($this->subCategory) && !empty($this->subCategory) ? $this->subCategory : Category::where('category_id', $this->category->id)->get()->pluck('id');
        $restaurants = Restaurant::
            join('category_restaurants', 'category_restaurants.restaurant_id', '=', 'restaurants.id')
            ->join('categories', 'categories.id', '=', 'category_restaurants.category_id')
            ->join('addresses', 'addresses.addressable_id', '=', 'restaurants.id')
            ->leftJoin('cart_restaurant', 'cart_restaurant.restaurant_id', '=', 'restaurants.id')
            ->leftJoin('comments', 'comments.cart_id', '=', 'cart_restaurant.cart_id')
            ->select(
            'restaurants.*',
            DB::raw('AVG(comments.score) AS score'),
            'addresses.latitude',
            'addresses.longitude',
            "addresses.id as address_id",
            DB::raw("6371 * acos(cos(radians(" . 4.639 . ")) * cos(radians(addresses.latitude)) * cos(radians(addresses.longitude) - radians(" . 53.822 . ")) + sin(radians(" . 4.639 . ")) * sin(radians(addresses.latitude))) AS distance"),
        )
            ->having('distance', '<', 5000000000)
            ->where($where)
            ->whereIn('category_restaurants.category_id', $subCategory)
            ->groupBy('addresses.id')
            ->orderBy($this->sortBy, 'asc')
            ->paginate(15);

        return $restaurants;
    }

    public function render()
    {
        return view('livewire.category.show-restaurants', [
            'restaurants' => $this->getRestaurants(),
        ]);
    }
}
