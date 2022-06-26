<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodType;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Http\Controllers\RestaurantController;

class RestaurantsTable extends Component
{
    use WithPagination;
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
        session()->flash('response', $response);
        $this->emit('restaurantEdited');
        $this->fetchData();
    }

    public function fetchData()
    {
        $this->foodTypes = FoodType::all();

        $where = [];
        if ($this->foodType != null && $this->foodType != 'All') {
            $where[] = ['food_type_id', '=', $this->foodType];
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
