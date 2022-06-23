<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            $user = User::find(auth()->id());
            if ($user->role == 'admin') {
                $column = 'confirm';
            }
            elseif ($user->role == 'restaurant') {
                if ($restaurant->confirm != 'active') {
                    return json_encode(['status' => 'error', 'message' => 'You can\'t active until your restaurant be confirmed']);
                }
                $column = 'status';
            }

            if ($restaurant->$column == 'active') {
                $restaurant->$column = 'inactive';
            }
            else {
                $restaurant->$column = 'active';
            }

            $restaurant->update(["$column" => $restaurant->$column]);

            return json_encode(['status' => 'success', 'message' => 'Restaurant status updated']);
        }
        $restaurant->update($request->all());
        return json_encode(['status' => 'success', 'message' => 'Restaurant updated']);
    }

}
