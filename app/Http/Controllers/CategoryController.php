<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Livewire\RestaurantCreate;

class CategoryController extends Controller
{

    public function index()
    {
        return view('dashboard.foodType');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|unique:categories,name',
        ]);

        if (Category::create(['name' => $data['name']])) {
            return json_encode(['status' => 'success', 'message' => 'Food type add successfully']);
        }
        return json_encode(['status' => 'error', 'message' => 'Food type can\'t add now!']);


    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'type' => 'required|min:2|unique:categories,name,' . $id
        ]);

        $category = Category::find($id);
        if ($category->update(['name' => $data['type']])) {
            return json_encode(['status' => 'success', 'message' => $category->name . ' Food type update successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $category->name . ' Food type can\'t update now!']);
    }


    public function destroy($id)
    {
        if (Category::find($id)->delete()) {
            return json_encode(['status' => 'success', 'message' => 'Food type update successfully']);
        }
        return json_encode(['status' => 'error', 'message' => 'Food type can\'t update now!']);
    }
}
