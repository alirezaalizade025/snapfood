<?php

namespace App\Http\Livewire\Dashboard\Admin\FoodParty;

use Livewire\Component;
use App\Models\FoodParty;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodPartyController;



class FoodPartyTable extends Component
{
    use Actions;
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
        $this->notification()->send([
            'title'       => 'Status Changed!',
            'description' => $response['message'],
            'icon'        => $response['status']
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
    }

    public function render()
    {
        return view('livewire.dashboard.admin.food-party.food-party-table', [
            'foodParties' => $this->fetchData()
        ]);
    }
}
