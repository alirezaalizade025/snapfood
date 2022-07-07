<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Food;

use App\Models\Food;
use Livewire\Component;
use App\Models\Category;
use App\Models\FoodParty;
use App\Models\Restaurant;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class ModalAddFood extends Component
{
    use Actions;
    use WithFileUploads;
    public $showingModal = false;
    public $title = 'Add Food';
    public $model;
    public $foodParties;
    public $price;
    public $discount;
    public $foodParty;
    public $finalPrice;
    public $name;
    public $restaurant_id;
    public $photo;
    public $category = [
        'id' => '',
        'name' => ''
    ];
    public $image;
    public $rawMaterials = [];
    public $i = 0;
    public $listeners = [
        'hideMe' => 'hideModal',
        'showAddFoodModal' => 'showModal',
        'imageUploaded' => 'imageUploaded',
    ];
    function imageUploaded($photo)
    {
        $this->photo = $photo;
    }

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


    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => ['required', 'string', 'max:255', 'unique_food_name:food,name,restaurant_id, ' . $this->restaurant_id],
            'price' => 'required|numeric',
            'discount' => 'digits_between:0,100',
            'foodParty' => 'nullable|exists:food_parties,id',
            'category' => 'required|exists:categories,id',
            'rawMaterials.*' => 'required|string|min:2|max:255',
        ],
        ['unique_food_name' => 'Food name already exists.']);

    }

    public function finalPrice()
    {
        $party = null;
        if ($this->foodParty != null)
            $party = $this->foodParties->where('id', $this->foodParty['id'])->first();
        if (is_null($party)) {
            $this->finalPrice = $this->price * (1 - (empty($this->discount) ? 0 : $this->discount) / 100);
        }
        else {
            $this->finalPrice = $this->price * (1 - ($party->discount) / 100);
        }
    }

    public function storeFood()
    {
        $request = new Request();
        $request->replace([
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'food_party_id' => $this->foodParty == null ? null : ($this->foodParty['id'] == 'None' ? null : $this->foodParty['id']),
            'category_id' => $this->category['id'],
            'raw_materials' => $this->rawMaterials,
            'image' => $this->image
        ]);

        $response = app("App\Http\Controllers\\" . $this->model . "Controller")->store($request);
        $response = json_decode($response, true);
        $this->notification()->send([
            'title' => 'Food Added!',
            'description' => $response['message'],
            'icon' => $response['status']
        ]);

        if ($response['status'] == 'success' && $this->photo != null) {
            $this->savePhoto($response['id']);
        }


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
        $this->photo = '';
        $this->rawMaterials = [];
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function mount()
    {
        if (auth()->user()->role != 'admin') {
            $this->foodParties = FoodParty::where('status', true)->get();
        }
        else {
            $this->foodParties = FoodParty::all();
        }
        $this->foodTypes = Category::all();
    }

    public function render()
    {
        return view('livewire.dashboard.restaurant.food.modal-add-food');
    }

    public function showModal()
    {
        $this->model = 'Food';
        $this->restaurant_id = Restaurant::where('user_id', auth()->user()->id)->first()->id;
        $this->showingModal = true;
        $this->resetErrorBag();
    }

    public function savePhoto($id)
    {
        $this->validate([
            'photo' => 'mimes:jpg,jpeg,png|max:5120', // 5MB Max
        ]);
        $fileName = now()->timestamp . '-' . $id . '.' . $this->photo->extension();
        $this->photo->storeAs('public/photos/food', $fileName);
        Food::find($id)->image()->create([
            'path' => $fileName
        ]);
    }

}
