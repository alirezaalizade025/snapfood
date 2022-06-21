<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FoodType;

class FoodTypesTable extends Component
{
    use WithPagination;
    public $search;
    protected $listeners = [
        'typeAdded' => 'fetchData',
        'itemDeleted' => 'fetchData',
        'typeEdited' => 'fetchData',
        'refreshFoodTypeTable' => 'fetchData'
    ];


    public function fetchData()
    {

        return FoodType::where('name', 'LIKE', "%$this->search%")->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'typePage');

    // TODO:dynamics per page with select in table
    }
    public function render()
    {

        return view('livewire.food-types-table', [
            'foodTypes' => $this->fetchData()
        ]);
    }
}
