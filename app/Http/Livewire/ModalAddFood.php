<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodType;
use App\Models\FoodParty;
use Illuminate\Http\Request;

class ModalAddFood extends Component
{
    public $showingModal = false;
    public $title = 'Edit item';
    public $model;
    public $foodParties;
    public $price;
    public $discount;
    public $foodParty;
    public $finalPrice;
    public $name;
    public $foodType = [
        'id' => '',
        'name' => ''
    ];
    public $image;


    public $listeners = [
        'hideMe' => 'hideModal',
        'showAddFoodModal' => 'showModal'
    ];

    public function finalPrice()
    {
        if (empty($this->price) | !is_numeric($this->price)) {
            $this->finalPrice = 0;
            return true;
        }
        if ($this->foodParty != null) {
            $party = $this->foodParties->where('id', $this->foodParty['id'])->first();
            $partyDiscount = 1 - ($party == null ? 0 : $party->discount) / 100;
        }
        else {
            $partyDiscount = 1;
        }
        $discount = 1 - (empty($this->discount) ? 0 : $this->discount) / 100;

        $this->finalPrice = $this->price * $discount * $partyDiscount;
    }

    public function storeFood()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'food_party_id' => $this->foodParty == null ? null : ($this->foodParty['id'] == 'None' ? null : $this->foodParty['id']),
            'food_type_id' => $this->foodType['id'],
            'image' => $this->image
        ]);

        $response = app("App\Http\Controllers\\" . $this->model . "Controller")->store($request);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->showingModal = false;
        $this->emit('refreshFoodTable');
        $this->name = '';
        $this->price = '';
        $this->discount = '';
        $this->foodParty = null;
        $this->foodType = [
            'id' => '',
            'name' => ''
        ];
        $this->image = '';
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function mount()
    {
        $this->foodParties = FoodParty::all();
        $this->foodTypes = FoodType::all();
    }

    public function render()
    {
        return view('livewire.modal-add-food');
    }

    public function showModal()
    {
        $this->model = 'Food';
        $this->showingModal = true;
    }
}
