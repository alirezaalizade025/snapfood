<?php

namespace App\Http\Livewire\Customer\Category;

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
        // TODO: set actual user's lat long for calc distance
        $where = [['restaurants.confirm', 'accept']];

        if ($this->search) {
            $where[] = ['restaurants.title', 'like', '%' . $this->search . '%'];
        }

        $subCategory = isset($this->subCategory) && !empty($this->subCategory) ? $this->subCategory : Category::where('category_id', $this->category->id)->get()->pluck('id');
        
        if (count($subCategory) == 0) {
            return collect([]);
        }
        
        return Restaurant::
            join('category_restaurants', 'category_restaurants.restaurant_id', '=', 'restaurants.id')
            ->join('categories', 'categories.id', '=', 'category_restaurants.category_id')
            ->join('addresses', 'addresses.addressable_id', '=', 'restaurants.id')
            ->join('carts', 'carts.restaurant_id', '=', 'restaurants.id')
            ->leftJoin('comments', 'comments.cart_id', '=', 'carts.id')
            ->select(
            'restaurants.*',
            DB::raw('AVG(comments.score) AS score'),
            'addresses.latitude',
            'addresses.longitude',
            "addresses.id as address_id",
            DB::raw("6371 * acos(cos(radians(" . 4.639 . ")) * cos(radians(addresses.latitude)) * cos(radians(addresses.longitude) - radians(" . 53.822 . ")) + sin(radians(" . 4.639 . ")) * sin(radians(addresses.latitude))) AS distance"),
        )
            ->having('distance', '<', 5000) //TODO:fix this km
            ->where($where)
            ->where('addressable_type', 'App\Models\Restaurant')
            ->whereIn('category_restaurants.category_id', $subCategory)
            ->groupBy('addresses.id')
            ->orderBy($this->sortBy, 'asc')
            ->paginate(15);
            

    }

    public function render()
    {
        return view('livewire.customer.category.show-restaurants', [
            'restaurants' => $this->getRestaurants(),
        ]);
    }
}
