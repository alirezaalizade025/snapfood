<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\FoodTypeController;



class AddFoodType extends Component
{
    public $name;
    public $response;
    public $componentType;
    public $showFlesh;

    protected $rules = [
        'name' => 'required|min:2|unique:food_types',
    ];
    protected $listeners = [
        'editType' => 'showEdit',
        'refreshComponent' => '$refresh'
    ];

    public function showEdit($typeID, $name)
    {
        $this->name = $name;
        $this->typeID = $typeID;
        $this->componentType = 'edit';
    }

    public function editType()
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['type' => $this->name]);
        $response = app(FoodTypeController::class)->update($request, $this->typeID);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->name = '';
        $this->emit('typeEdited');
        $this->componentType = 'add';
        if ($response['status'] == 'success') {
            $this->resetErrorBag();
        }
    }

    public function addType()
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['type' => $this->name]);
        $response = app(FoodTypeController::class)->store($request);
        $response = json_decode($response, true);

        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);

        $this->name = '';
        $this->emit('typeAdded');
        $this->showFlesh = true;
        if ($response['status'] == 'success') {
            $this->resetErrorBag();
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.add-food-type');
    }


}
