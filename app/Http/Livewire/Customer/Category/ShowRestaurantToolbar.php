<?php

namespace App\Http\Livewire\Customer\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Request;


class ShowRestaurantToolbar extends Component
{
    public $category;
    public $subCategory = [];

    public function handleSubCategory($id)
    {
        if (in_array($id, $this->subCategory)) {
            unset($this->subCategory[array_search($id, $this->subCategory)]);
        }
        else {
            $this->subCategory[] = $id;
        }
        $this->emit('changeSubCategory', $this->subCategory);
    }

    public function mount()
    {
        $this->categories = Category::where('category_id', $this->category->id)->get();
    }
    public function render()
    {
        return view('livewire.customer.category.show-restaurant-toolbar');
    }
}
