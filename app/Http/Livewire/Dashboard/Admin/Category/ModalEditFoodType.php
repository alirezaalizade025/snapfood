<?php

namespace App\Http\Livewire\Dashboard\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
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
    public $mainCategories = [];

    public $subCategory;
    protected $listeners = [
        'hideMe' => 'hideModal',
        'showModalEditCategory' => 'showModal',
    ];


    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function showModal($typeID, $name)
    {
        $this->showingModal = true;
        $this->name = $name;
        $this->typeID = $typeID;
        $this->subCategory = Category::find($typeID)->category_id;
        $this->mainCategories = Category::where('category_id', null)->get();
        $this->resetErrorBag();
    }

    public function editType()
    {
        $request = new Request([
            'type' => $this->name,
            'category_id' => isset($this->subCategory)& $this->subCategory != 'main' ? $this->subCategory : null
        ]);
        $response = app(CategoryController::class)->update($request, $this->typeID);
        $response = json_decode($response, true);
        $this->notification()->send([
            'title' => 'Category Edited!',
            'description' => $response['message'],
            'icon' => $response['status']
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
        return view('livewire.dashboard.admin.category.modal-edit-food-type');
    }
}
