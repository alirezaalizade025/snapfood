<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodParty;

class FoodPartyTable extends Component
{
    public $search;

    public function fetchData()
    {


        $where = [];
        // if ($this->foodType != null && $this->foodType != 'All') {
        //     $where[] = ['food_type_id', '=', $this->foodType];
        // }
        // if ($this->foodParty != null && $this->foodParty != 'All') {
        //     $where[] = ['food_party_id', '=', $this->foodParty];
        // }

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
