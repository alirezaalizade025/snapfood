<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodParty;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodPartyController;



class FoodPartyTable extends Component
{
    public $search;
    public $photo;
    public $listeners = [
        'refreshFoodPartyTable' => 'fetchData'
    ];

    public function changeStatus($id)
    {
        $request = new Request();
        $request->replace(['status' => true]);
        $response = app(FoodPartyController::class)->update($request, $id);
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
        if ($this->search != null) {
            $where[] = ['name', 'like', '%' . $this->search . '%'];
        }

        return FoodParty::where($where)
            ->orderBy('id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);


    // TODO:dynamics per page with select in table
    }

    public function render()
    {
        return view('livewire.food-party-table', [
            'foodParties' => $this->fetchData()
        ]);
    }
}
