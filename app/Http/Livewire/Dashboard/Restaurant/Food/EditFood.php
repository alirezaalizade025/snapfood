<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Food;

use App\Models\Food;
use Livewire\Component;
use App\Models\Category;
use App\Models\FoodParty;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditFood extends Component
{
    use Actions;
    use WithFileUploads;
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
    public $photo;
    public $image;

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
        $this->foodParties = FoodParty::where('status', true)->get();
        $this->foodTypes = Category::where('category_id', '!=', null)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.restaurant.food.edit-food');
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
        $this->image = $item->image->path;
        $this->photo;
        $this->foodType = $item->category->toArray();
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
            'food_party_id' => $this->foodParty == null || !$this->foodParty ? null : ($this->foodParty['id'] == 'None' ? null : $this->foodParty['id']),
            'category_id' => $this->foodType['id'],
            'raw_materials' => $this->rawMaterials,
        ]);

        $response = app("App\Http\Controllers\\" . $this->model . "Controller")->update($request, $this->selectID);
        $response = json_decode($response, true);
        $this->notification()->send([
            'title'       => 'Food Edited!',
            'description' => $response['message'],
            'icon'        => $response['status']
        ]);

        if ($response['status'] == 'success' && $this->photo != null) {
            $this->updatePhoto($response['id'], $response['image']);
        }

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
            'rawMaterials.*' => 'required|string|min:2|max:255', ]);
    }


    public function updatePhoto($id, $image)
    {
        if (!is_null($image)) {
            Storage::delete('public/photos/food', $image['path']);
        }

        $this->validate([
            'photo' => 'mimes:jpg,jpeg,png|max:5120', // 5MB Max
        ]);
        $fileName = now()->timestamp . '-' . $id . '.' . $this->photo->extension();

        $this->photo->storeAs('public/photos/food', $fileName);
        Food::find($id)->image()->update([
            'path' => $fileName
        ]);
        $this->photo = '';
    }

}
