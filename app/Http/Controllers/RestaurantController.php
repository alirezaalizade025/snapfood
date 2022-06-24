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

    public function store(Request $request)
    {
        $request->validate([
            'restaurant.name' => 'required|min:2',
            'restaurant.address' => 'required|min:2|max:255',
            'restaurant.phone' => 'required|numeric|digits:11',
            'restaurant.food_type_id' => 'required|exists:food_types,id',
            'restaurant.bank_account' => 'required|digits:16',
        ]);
        $location = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);


        $restaurant = new Restaurant();
        $restaurant->name = $request->restaurant['name'];
        $restaurant->user_id = auth()->id();
        $restaurant->phone = $request->restaurant['phone'];
        $restaurant->bank_account = $request->restaurant['bank_account'];
        $restaurant->address = $request->restaurant['address'];
        $restaurant->food_type_id = $request->restaurant['food_type_id'];
        $restaurant->latitude = $location['latitude'];
        $restaurant->longitude = $location['longitude'];
        $restaurant->save();
        return json_encode(['status' => 'success', 'message' => 'Restaurant add successfully']);
    }

    public function show($id)
    {
        $restaurantInfo = ResTaurant::where('user_id', auth()->user()->id)->get()->first();
        return view('dashboard.myRestaurant', compact('restaurantInfo'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (in_array('status', $request->all())) {
            $user = User::find(auth()->id());
            if ($user->role == 'admin') {
                if ($restaurant->confirm == 'accept') {
                    $restaurant->confirm = 'denied';
                    $restaurant->status = 'inactive';
                }
                else {
                    $restaurant->confirm = 'accept';
                }
                $column = 'confirm';
            }
            elseif ($user->role == 'restaurant') {
                if ($restaurant->confirm != 'accept') {
                    return json_encode(['status' => 'error', 'message' => 'You can\'t active until your restaurant be confirmed']);
                }
                if ($restaurant->status == 'active') {
                    $restaurant->status = 'inactive';
                }
                else {
                    $restaurant->status = 'active';
                }
                $column = 'status';
            }


            $restaurant->update(["$column" => $restaurant->$column]);

            return json_encode(['status' => 'success', 'message' => 'Restaurant status updated']);
        }
        $data = $request->validate([
            'restaurant.name' => 'required|min:2',
            'restaurant.address' => 'required|min:2|max:255',
            'restaurant.phone' => 'required|numeric|digits:11',
            'restaurant.status' => 'required|min:2',
            'restaurant.food_type_id' => 'required|exists:food_types,id',
            'restaurant.bank_account' => 'required|digits:16',
        ]);
        $location = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $data = $request->all()['restaurant']->toArray();
        $data['confirm'] = 'waiting';
        $data['status'] = 'inactive';
        $data = array_merge($data, $location);
        $restaurant->update($data);
        return json_encode(['status' => 'success', 'message' => 'Restaurant updated']);
    }

}
