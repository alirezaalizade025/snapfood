<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FoodType;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\RestaurantController;

class MyRestaurantShow extends Component
{
    public $restaurant;


    public $listeners = [
        'refreshComponent' => 'fetchData',
        'mapClicked' => 'setLocation',
    ];


    protected $rules = [
        'restaurant.title' => 'required|min:2',
        'restaurant.address' => 'required|min:2|max:255',
        'restaurant.phone' => 'required|numeric|digits:11',
        'restaurant.status' => 'required|min:2',
        'restaurant.food_type_id' => 'required|exists:food_types,id',
        'restaurant.bank_account' => 'required|digits:16',
    ];

    public function setLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateRestaurant()
    {
        $request = new Request();
        $request->replace([
            'restaurant' => $this->restaurant,
            'latitude' => $this->latitude ?? false,
            'longitude' => $this->longitude ?? false,
        ]);
        if ($this->formType == 'add') {
            $response = app(RestaurantController::class)->store($request);
        }
        elseif ($this->formType == 'update') {
            $response = app(RestaurantController::class)->update($request, $this->restaurant->id);
        }
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->formType = 'update';
        }
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        // $this->showingModal = false;
        $this->fetchData();
    }

    public function changeStatus()
    {
        $request = new Request();
        $request->replace(['status' => true]);
        $response = app(RestaurantController::class)->update($request, $this->restaurant->id);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->status = Restaurant::find($this->restaurant->id)->status;
        $this->fetchData();
    }

    public function fetchData()
    {
        $id = auth()->user()->id;
        $this->foodTypes = FoodType::all();
        $this->restaurant = Restaurant::where('user_id', $id)->get()->first();
        if (!empty($this->restaurant)) {
            $this->formType = 'update';
            return $this->restaurant;
        }

        $this->formType = 'add';
    }

    public function mount()
    {
        $this->restaurant = $this->fetchData();
    }

    public function render()
    {
        return view('livewire.my-restaurant-show');
    }
}
