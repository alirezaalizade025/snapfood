<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Restaurant;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Http\Controllers\RestaurantController;

class RestaurantsTable extends Component
{
    use WithPagination;
    use Actions;
    public $search;
    public $foodType;

    protected $listeners = [
        'typeAdded' => 'fetchData',
        'itemDeleted' => 'fetchData',
        'restaurantEdited' => 'fetchData'
    ];


    public function changeStatus($id)
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['status' => true]);
        $response = app(RestaurantController::class)->update($request, $id);
        $response = json_decode($response, true);
        $this->notification()->send([
            'title'       => 'Status Changed!',
            'description' => $response['message'],
            'icon'        => $response['status']
        ]);
        $this->emit('restaurantEdited');
        $this->fetchData();
    }

    public function fetchData()
    {
        $this->foodTypes = Category::all();

        $where = [];
        if ($this->foodType != null && $this->foodType != 'All') {
            $where[] = ['categories.id', '=', $this->foodType];
            return (Restaurant::
            Join('category_restaurants', 'category_restaurants.restaurant_id', '=', 'restaurants.id')
            ->join('categories', 'category_restaurants.category_id', '=', 'categories.id')
            ->where($where)
            ->orderBy('name', 'desc')
            ->select('restaurants.*', 'categories.name as name')
            ->paginate(10));
        }
        if ($this->search != null) {
            $where[] = ['title', 'like', '%' . $this->search . '%'];
        }
        return Restaurant::where($where)
            ->orderBy('id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
    public function render()
    {
        return view('livewire.restaurants-table', [
            'restaurants' => $this->fetchData()
        ]);
    }
}
