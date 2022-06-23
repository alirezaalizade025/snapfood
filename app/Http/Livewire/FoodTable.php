<?php

namespace App\Http\Livewire;

use App\Models\Food;
use Livewire\Component;
use App\Models\FoodType;
use App\Models\FoodParty;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Http\Controllers\FoodController;

class FoodTable extends Component
{
    use WithPagination;
    public $search;
    public $foodType;
    public $foodParty;
    public $message;

    protected $listeners = [
        'refreshFoodTable' => 'fetchData'
    ];
    public function changeStatus($id)
    {
        $request = new Request();
        $request->replace(['status' => true]);
        $response = app(FoodController::class)->update($request, $id);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->fetchData();
    }

    public function fetchData()
    {


        $where = [];
        if ($this->foodType != null && $this->foodType != 'All') {
            $where[] = ['food_type_id', '=', $this->foodType];
        }
        if ($this->foodParty != null && $this->foodParty != 'All') {
            $where[] = ['food_party_id', '=', $this->foodParty];
        }

        if ($this->search != null) {
            $where[] = ['name', 'like', '%' . $this->search . '%'];
        }

        if (auth()->user()->role != 'admin') {
            return Food::select(['food.*', 'restaurants.user_id'])
                ->where($where)
                ->where('restaurants.user_id', auth()->id())
                ->leftJoin('restaurants', 'restaurants.id', '=', 'food.restaurant_id')
                ->orderBy('food.updated_at', 'desc')
                ->orderBy('food.id')
                ->paginate(10);
        }
        else {
            return Food::where($where)
                ->orderBy('updated_at', 'desc')
                ->orderBy('id')
                ->paginate(10);
        }
    }

    public function mount()
    {
        if (auth()->user()->role != 'admin') {
            $this->foodParties = FoodParty::where('status', true)->get();
        }
        else {
            $this->foodParties = FoodParty::all();
        }

        $this->foodTypes = FoodType::all();
    }

    public function render()
    {
        return view('livewire.food-table', [
            'foods' => $this->fetchData()
        ]);
    }
}
