<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Livewire\RestaurantCreate;

class CategoryController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Category::class);
        return view('dashboard.foodType');
    }


    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $data = $request->validate([
            'name' => 'required|min:2|unique:categories,name',
            'category_id' => 'nullable',
        ]);
  
        if (Category::create($data)) {
            return json_encode(['status' => 'success', 'message' => 'Food type add successfully']);
        }
        return json_encode(['status' => 'error', 'message' => 'Food type can\'t add now!']);


    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $this->authorize('update', $category);

        $data = $request->validate([
            'type' => 'required|min:2|unique:categories,name,' . $id,
            'category_id' => 'nullable',
        ]);

        if ($category->update($data)) {
            return json_encode(['status' => 'success', 'message' => $category->name . ' Food type update successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $category->name . ' Food type can\'t update now!']);
    }


    public function destroy($id)
    {
        $category = Category::find($id);
        $this->authorize('delete', $category);

        if ($category->delete()) {
            return json_encode(['status' => 'success', 'message' => 'Food type update successfully']);
        }
        return json_encode(['status' => 'error', 'message' => 'Food type can\'t update now!']);
    }
}
