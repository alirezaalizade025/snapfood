<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Food;

use App\Models\Food;
use Livewire\Component;
use App\Models\Category;
use App\Models\FoodParty;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Http\Controllers\FoodController;

class FoodTable extends Component
{
    use Actions;
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
        $this->notification([
            'title'       => 'Status changed!',
            'description' => $response['message'],
            'icon'        => $response['status']
        ]);
        $this->fetchData();
    }
    
    public function fetchData()
    {
        $where = [];
        
        if (auth()->user()->role != 'admin') {
            if ($this->foodType != null && $this->foodType != 'All') {
                $where[] = ['food.category_id', '=', $this->foodType];
            }
            if ($this->foodParty != null && $this->foodParty != 'All') {
                $where[] = ['food.food_party_id', '=', $this->foodParty];
            }
            
            if ($this->search != null) {
                $where[] = ['food.name', 'like', '%' . $this->search . '%'];
            }
            
            return Food::select(['food.*', 'restaurants.user_id'])
                ->where($where)
                ->where('restaurants.user_id', auth()->id())
                ->join('restaurants', 'restaurants.id', '=', 'food.restaurant_id')
                ->orderBy('food.name', 'asc')
                ->orderBy('food.id')
                ->paginate(20);
        }
        else {
            if ($this->foodType != null && $this->foodType != 'All') {
                $where[] = ['category_id', '=', $this->foodType];
            }
            if ($this->foodParty != null && $this->foodParty != 'All') {
                $where[] = ['food_party_id', '=', $this->foodParty];
            }
            
            if ($this->search != null) {
                $where[] = ['name', 'like', '%' . $this->search . '%'];
            }
            return Food::where($where)
            ->orderBy('updated_at', 'desc')
            ->orderBy('id')
            ->paginate(20);
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

        $this->foodTypes = Category::where('category_id', '!=', null)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.restaurant.food.food-table', [
            'foods' => $this->fetchData()
        ]);
    }
}
