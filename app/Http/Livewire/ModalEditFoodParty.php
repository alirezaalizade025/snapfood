<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodParty;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodPartyController;

class ModalEditFoodParty extends Component
{
    public $showingModal = false;
    public $title = 'Edit food party';
    public $model = 'FoodParty';
    public $selectID;
    public $name;
    public $discount;

    public $listeners = [
        'hideMe' => 'hideModal',
        'showEditModal' => 'showModal'
    ];

    public function updated($propertyName)
    {
        // TODO:implement unique for all update
        $this->validateOnly($propertyName, [
            'name' => 'required|min:2|max:255|unique:food_parties,name,' . $this->selectID,
            'discount' => 'required|numeric|between:0,99.99'
        ]);
    }

    public function showModal($id)
    {
        $this->selectID = $id;
        $item = FoodParty::find($id);
        $this->name = $item->name;
        $this->discount = $item->discount;
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function updateFoodParty()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
            'discount' => $this->discount,
        ]);
        $response = app(FoodPartyController::class)->update($request, $this->selectID);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $response['status'] == 'success' ? 'success' : 'danger',
                'message' => $response['message']
            ]);
            $this->showingModal = false;
            $this->emit('refreshFoodTable');
        }
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function render()
    {
        return view('livewire.modal-edit-food-party');
    }
}
