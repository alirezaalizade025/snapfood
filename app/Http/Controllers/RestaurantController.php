<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        return view('dashboard.restaurant');
    }

    public function show(Restaurant $restaurant)
    {
        $foodTypes = FoodType::all();
        return view('dashboard.myRestaurant', compact('restaurant', 'foodTypes'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (in_array('status', $request->all())) {
            if ($restaurant->status == 'active') {
                $restaurant->status = 'inactive';
            }
            else {
                $restaurant->status = 'active';
            }
            $restaurant->update(['status' => $restaurant->status]);
            return json_encode(['status' => 'success', 'message' => 'Restaurant status updated']);
        }
        $restaurant->update($request->all());
        return json_encode(['status' => 'success', 'message' => 'Restaurant updated']);
    }

}
