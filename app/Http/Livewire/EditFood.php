<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodType;
use App\Models\FoodParty;
use Illuminate\Http\Request;

class EditFood extends Component
{
    public $showingModal = false;
    public $title = 'Edit item';
    public $selectID;
    public $model;
    public $foodParties;
    public $price;
    public $discount;
    public $foodParty;
    public $finalPrice;
    public $rawMaterials = [];
    public $i = 0;

    public $listeners = [
        'hideMe' => 'hideModal',
        'showEditFoodModal' => 'showModal'
    ];

    public function addInput($i)
    {
        $i++;
        $this->i = $i;
        $this->rawMaterials[$i] = '';
    }

    public function removeInput($i)
    {
        unset($this->rawMaterials[$i]);
    }

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

    public function mount()
    {
        $this->foodParties = FoodParty::all();
        $this->foodTypes = FoodType::all();
    }

    public function render()
    {
        return view('livewire.edit-food');
    }

    public function showModal($model, $id)
    {
        $this->resetErrorBag();
        $this->selectID = $id;
        $this->model = $model;
        $model = "App\Models\\" . $model;
        $item = $model::find($id);
        $this->name = $item->name;
        $this->price = $item->price;
        $this->discount = $item->discount;
        if ($item->foodParty != null) {
            $this->foodParty = $item->foodParty->toArray();
        }
        $this->image = $item->image;
        $this->foodType = $item->foodType->toArray();
        $this->showingModal = true;
        $this->finalPrice();
        $this->rawMaterials = $item->rawMaterials->map(function ($item) {
            return $item->name;
        })->toArray();
        $this->i = count($this->rawMaterials);
    }

    public function updateFood()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'food_party_id' => $this->foodParty == null ? null : ($this->foodParty['id'] == 'None' ? null : $this->foodParty['id']),
            'food_type_id' => $this->foodType['id'],
            'raw_materials' => $this->rawMaterials,
            'image' => $this->image
        ]);

        $response = app("App\Http\Controllers\\" . $this->model . "Controller")->update($request, $this->selectID);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->showingModal = false;
        $this->emit('refreshFoodTable');
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => 'required|min:2|max:255|unique:food,name,' . $this->selectID,
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'foodParty' => 'numeric',
            'foodType' => 'numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rawMaterials.*' => 'required|string|min:2|max:255', ]);
    }

}
