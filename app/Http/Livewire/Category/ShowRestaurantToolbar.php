<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class ShowRestaurantToolbar extends Component
{
    public function mount()
    {
        $this->categories = Category::all();
    }
    public function render()
    {
        return view('livewire.category.show-restaurant-toolbar');
    }
}
