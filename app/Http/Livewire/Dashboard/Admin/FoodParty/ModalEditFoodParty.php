<?php

namespace App\Http\Livewire\Dashboard\Admin\FoodParty;

use Livewire\Component;
use App\Models\FoodParty;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodPartyController;

class ModalEditFoodParty extends Component
{
    use Actions;
    public $showingModal = false;
    public $title = 'Edit food party';
    public $model = 'FoodParty';
    public $selectID;
    public $name;
    public $discount;
    public $start_at;
    public $expires_at;

    public $listeners = [
        'hideMe' => 'hideModal',
        'showEditModal' => 'showModal'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|min:2|max:255|unique:food_parties,name,' . $this->selectID,
            'discount' => 'required|numeric|between:0,99.99',
            'start_at' => 'required|date',
            'expires_at' => 'required|date|after:start'
        ]);
    }

    public function showModal($id)
    {
        $this->selectID = $id;
        $item = FoodParty::find($id);
        $this->name = $item->name;
        $this->discount = $item->discount;
        $this->start_at = $item->start_at;
        $this->expires_at = $item->expires_at;
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function updateFoodParty()
    {
        $request = new Request([
            'name' => $this->name,
            'discount' => $this->discount,
            'start_at' => $this->start_at,
            'expires_at' => $this->expires_at
        ]);

        $response = app(FoodPartyController::class)->update($request, $this->selectID);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->notification()->send([
                'title'       => 'Food Party Edited!',
                'description' => $response['message'],
                'icon'        => $response['status']
            ]);
            $this->showingModal = false;
            $this->emit('refreshFoodPartyTable');
        }
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function render()
    {
        return view('livewire.dashboard.admin.food-party.modal-edit-food-party');
    }
}
