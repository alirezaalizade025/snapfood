<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\RestaurantController;

class MyRestaurantShow extends Component
{
    public $restaurant;
    public $foodTypes;
    public $name;
    public $address;
    public $phone;
    public $status;
    public $foodTypeId;
    public $foodTypeName;
    public $bankAccount;
    public $listeners = [
        'refreshComponent' => '$refresh',
    ];


    protected $rules = [
        'name' => 'required|min:2',
        'address' => 'required|min:2|max:255',
        'phone' => 'required|integer|min:11',
        'status' => 'required|min:2',
        'foodTypeId' => 'required|exists:food_types,id',
        'bankAccount' => 'required|digits:16',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateRestaurant()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'status' => $this->status,
            'foodTypeId' => $this->foodTypeId,
            'bankAccount' => $this->bankAccount,
        ]);

        $response = app(RestaurantController::class)->update($request, $this->restaurant->id);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->showingModal = false;
        $this->emit('refreshComponent');
    }

    public function changeStatus()
    {
        $request = new Request();
        $request->replace(['status' => true]);
        $response = app(RestaurantController::class)->update($request, $this->restaurant->id);
        $response = json_decode($response, true);
        session()->flash('response', $response);
        $this->render();
        $this->status = Restaurant::find($this->restaurant->id)->status;
    }

    public function mount()
    {
        $this->name = $this->restaurant->name;
        $this->address = $this->restaurant->address;
        $this->phone = $this->restaurant->phone;
        $this->status = $this->restaurant->status;
        $this->foodTypeId = $this->restaurant->food_type_id;
        $this->foodTypeName = $this->restaurant->foodType->name;
        $this->bankAccount = $this->restaurant->bank_account;
    }

    public function render()
    {
        return view('livewire.my-restaurant-show');
    }
}
