<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\FoodTypeController;

class ModalAddFoodType extends Component
{
    public $showingModal = false;
    public $title = 'Add Food Type';
    public $model = 'FoodType';
    public $discount;
    public $name;
    protected $rules = [
        'name' => 'required|min:2|max:255|unique:food_types',
    ];
    public $listeners = [
        'hideMe' => 'hideModal',
        'showAddFoodTypeModal' => 'showModal'
    ];

    public function updated($propertyName)
    {
        return $this->validateOnly($propertyName);
    }

    public function storeFoodType()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
        ]);

        $response = app(FoodTypeController::class)->store($request);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $response['status'] == 'success' ? 'success' : 'danger',
                'message' => $response['message']
            ]);
            $this->showingModal = false;
            $this->emit('refreshFoodTypeTable');
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
        return view('livewire.modal-add-food-type');
    }
}
