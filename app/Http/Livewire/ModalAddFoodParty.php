<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodPartyController;

class ModalAddFoodParty extends Component
{
    public $showingModal = false;
    public $title = 'Add Food Party';
    public $model = 'FoodParty';
    public $discount;
    public $name;
    protected $rules = [
        'name' => 'required|min:2|max:255|unique:food_parties',
        'discount' => 'required|numeric|between:0,99.99'
    ];
    public $listeners = [
        'hideMe' => 'hideModal',
        'showAddFoodModal' => 'showModal'
    ];

    public function updated($propertyName)
    {
        return $this->validateOnly($propertyName);
    }

    public function storeFoodParty()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
            'discount' => $this->discount,
        ]);
        $response = app(FoodPartyController::class)->store($request);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $response['status'] == 'success' ? 'success' : 'danger',
                'message' => $response['message']
            ]);
            $this->showingModal = false;
            $this->emit('refreshFoodPartyTable');
            $this->name = '';
            $this->discount = '';
        }
        else {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $response['status'] == 'success' ? 'success' : 'danger',
                'message' => $response['message']
            ]);
        }
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }


    public function showModal()
    {
        $this->showingModal = true;
    }

    public function render()
    {
        return view('livewire.modal-add-food-party');
    }
}
