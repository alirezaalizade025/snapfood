<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\RestaurantController;
use App\Models\CategoryRestaurant;

class MyRestaurantShow extends Component
{
    public $restaurant;
    public $selectedCategory;
    public $restaurantCategory;


    public $listeners = [
        'refreshComponent' => 'fetchData',
        'mapClicked' => 'setLocation',
    ];


    protected $rules = [
        'restaurant.title' => 'required|min:2',
        'restaurant.address' => 'required|min:2|max:255',
        'restaurant.phone' => 'required|numeric|digits:11',
        'restaurant.status' => 'required|min:2',
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

        $this->restaurant['category'] = isset($this->restaurantCategory) ? $this->restaurantCategory->map(function ($item) {
            return $item['id'];
        })->toArray() : [];

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

    public function handelCategory($id)
    {
        // dd($this->restaurantCategory);
        if ($this->restaurantCategory != null && $this->restaurantCategory->contains('id', $id)) {
            $this->restaurantCategory = collect($this->restaurantCategory)
                ->filter(function ($item, $index) use ($id) {
                return $item['id'] != $id;
            });
        }
        else {
            $this->restaurantCategory[] = $this->foodTypes->where('id', $id)->first();
            $this->restaurantCategory = collect($this->restaurantCategory)->sortBy('id');
        }
    }

    public function fetchData()
    {
        $id = auth()->user()->id;
        $this->foodTypes = Category::all();
        $this->restaurant = Restaurant::where('user_id', $id)->get()->first();
        if (!empty($this->restaurant)) {
            $this->restaurantCategory = CategoryRestaurant::where('restaurant_id', $this->restaurant->id)->get()->map(function ($item) {
                return $item->category;
            });
            $this->restaurant->address = $this->restaurant->addressInfo->address ?? null;
            $this->latitude = $this->restaurant->addressInfo->latitude ?? null;
            $this->longitude = $this->restaurant->addressInfo->longitude ?? null;
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
