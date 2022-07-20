<?php

namespace App\Http\Livewire\Dashboard\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;

class ModalAddFoodType extends Component
{
    use Actions;
    public $showingModal = false;
    public $title = 'Add Food Type';
    public $model = 'Category';
    public $discount;
    public $name;
    public $mainCategories = [];
    public $subCategory;

    protected $rules = [
        'name' => 'required|min:2|max:255|unique:categories',
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
            'category_id' => isset($this->subCategory) & $this->subCategory != 'main' ? $this->subCategory : null,
        ]);

        $response = app(CategoryController::class)->store($request);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            $this->notification()->send([
                'title' => 'Category Added!',
                'description' => $response['message'],
                'icon' => $response['status']
            ]);
            $this->showingModal = false;
            $this->emit('refreshCategoryTable');
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
        $this->mainCategories = Category::where('category_id', null)->get();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.dashboard.admin.category.modal-add-food-type');
    }
}
