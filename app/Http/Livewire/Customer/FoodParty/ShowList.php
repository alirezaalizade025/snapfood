<?php

namespace App\Http\Livewire\Customer\FoodParty;

use Livewire\Component;
use App\Models\Food;

class ShowList extends Component
{
    public $foodParties;

    public function mount()
    {
        $this->foodParties = Food::
            join('food_parties', 'food.food_party_id', '=', 'food_parties.id')
            ->whereNotNull('food.food_party_id')
            ->where('food_parties.status', 1)
            ->select('food.*', 'food_parties.name as food_party_name' , 'food_parties.discount as discount')
            ->get()
            ->groupBy('food_party_id')
            ->map(function ($foodParty) {
                return [
                    'food_party' => $foodParty[0]->foodParty,
                    'foods' => $foodParty
                ];
            });
            

        // dd($this->foodParties);
    }
    public function render()
    {
        return view('livewire.customer.food-party.show-list');
    }
}
