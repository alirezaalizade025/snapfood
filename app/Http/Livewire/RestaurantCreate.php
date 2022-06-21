<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\FoodTypeController;



class RestaurantCreate extends Component
{
    public $type;
    public $response;
    public $componentType;
    public $showFlesh;

    protected $rules = [
        'type' => 'required|min:2',
    ];
    protected $listeners = [
        'editType' => 'showEdit',
        'refreshComponent' => '$refresh'
    ];

    public function showEdit($typeID, $name)
    {
        $this->type = $name;
        $this->typeID = $typeID;
        $this->componentType = 'edit';
    }

    public function editType()
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['type' => $this->type]);
        $response = app(FoodTypeController::class)->update($request, $this->typeID);
        $response = json_decode($response, true);
        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);
        $this->type = '';
        $this->emit('typeEdited');
        $this->componentType = 'add';

    }

    public function addType()
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['type' => $this->type]);
        $response = app(FoodTypeController::class)->store($request);
        $response = json_decode($response, true);

        $this->dispatchBrowserEvent('banner-message', [
            'style' => $response['status'] == 'success' ? 'success' : 'danger',
            'message' => $response['message']
        ]);

        $this->type = '';
        $this->emit('typeAdded');
        $this->showFlesh = true;

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    } // TODO:real time validate
    public function render()
    {
        return view('livewire.restaurant-create');
    }


}
