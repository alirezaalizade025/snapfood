<?php

namespace App\Http\Livewire\Dashboard\Admin\FoodParty;

use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodPartyController;

class ModalAddFoodParty extends Component
{
    use Actions;
    public $showingModal = false;
    public $title = 'Add Food Party';
    public $model = 'FoodParty';
    public $discount;
    public $name;
    public $start;
    public $expire;

    protected $rules = [
        'name' => 'required|min:2|max:255|unique:food_parties',
        'discount' => 'required|numeric|between:0,99.99',
        'start' => 'required|date|after:now',
        'expire' => 'required|date|after:start'
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
        $request = new Request([
            'name' => $this->name,
            'discount' => $this->discount,
            'start_at' => $this->start,
            'expires_at' => $this->expire
        ]);
        $response = app(FoodPartyController::class)->store($request);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->notification()->send([
                'title' => 'Food Party added!',
                'description' => $response['message'],
                'icon' => $response['status']
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
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.dashboard.admin.food-party.modal-add-food-party');
    }
}
