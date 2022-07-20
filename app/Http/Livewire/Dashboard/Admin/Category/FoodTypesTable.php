<?php

namespace App\Http\Livewire\Dashboard\Admin\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class FoodTypesTable extends Component
{
    use WithPagination;
    public $search;

    protected $listeners = [
        'typeAdded' => 'fetchData',
        'itemDeleted' => 'fetchData',
        'typeEdited' => 'fetchData',
        'refreshCategoryTable' => 'fetchData'
    ];


    public function fetchData()
    {
        return Category::where('name', 'LIKE', "%$this->search%")->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'typePage');
    }
    public function render()
    {

        return view('livewire.dashboard.admin.category.food-types-table', [
            'foodTypes' => $this->fetchData()
        ]);
    }
}
