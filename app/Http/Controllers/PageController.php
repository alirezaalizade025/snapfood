<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        return view('home', compact('categories'));
    }

    /*
     * Show all food in a category
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCategoryRestaurant($id)
    {
        $category = Category::with('restaurants')->find($id);
        return view('category.categoryIndex', compact('category'));
    }
}
