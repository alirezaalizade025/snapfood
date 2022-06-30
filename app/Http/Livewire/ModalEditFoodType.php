<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Http\Controllers\CategoryController;

class ModalEditFoodType extends Component
{
    use Actions;
    public $showingModal = false;
    public $name;
    public $title = 'Edit Food Type';
    public $response;
    public $componentType;
    public $showFlesh;
    protected $listeners = [
        'hideMe' => 'hideModal',
        'showModalEditFoodType' => 'showModal',
    ];


    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function showModal($typeID, $name)
    {
        $this->name = $name;
        $this->typeID = $typeID;
        $this->showingModal = true;
        $this->resetErrorBag();
    }

    public function editType()
    {
        $request = new \Illuminate\Http\Request();
        $request->replace(['type' => $this->name]);
        $response = app(CategoryController::class)->update($request, $this->typeID);
        $response = json_decode($response, true);
        $this->notification()->send([
            'title'       => 'Category Edited!',
            'description' => $response['message'],
            'icon'        => $response['status']
        ]);
        $this->name = '';
        $this->emit('typeEdited');
        $this->componentType = 'add';
        if ($response['status'] == 'success') {
            $this->resetErrorBag();
            $this->emit('hideMe');
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|min:2|unique:categories,name,' . $this->typeID,
        ]);
    }
    public function render()
    {
        return view('livewire.modal-edit-food-type');
    }
}
