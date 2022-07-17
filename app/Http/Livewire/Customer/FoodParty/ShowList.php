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
            ->join('restaurants', 'food.restaurant_id', '=', 'restaurants.id')
            ->whereNotNull('food.food_party_id')
            ->where('food_parties.status', 1)
            ->where('food.status', 1)
            ->where([['restaurants.status', 1], ['restaurants.confirm', 'accept']])
            ->select(
            'food.*',
            'food_parties.name as food_party_name',
            'food_parties.discount as discount',
            'food_parties.status as food_party_status',
            'food.status as food_status'
            )
            ->get()
            ->groupBy('food_party_id')
            ->map(function ($foodParty) {
            return [
            'food_party' => $foodParty[0]->foodParty,
            'foods' => $foodParty
            ];
            
        });
    }
    public function render()
    {
        return view('livewire.customer.food-party.show-list');
    }
}
