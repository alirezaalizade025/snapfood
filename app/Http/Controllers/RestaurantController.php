<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\FoodType;
use App\Models\Restaurant;
use App\Models\WeekSchedule;
use Illuminate\Http\Request;
use App\Models\CategoryRestaurant;

class RestaurantController extends Controller
{
    public function index()
    {
        return view('dashboard.restaurant');
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant.title' => 'required|min:2',
            'restaurant.phone' => 'required|numeric|digits:11',
            'restaurant.bank_account' => 'required|digits:16',
        ]);

        $category = $request->validate([
            'restaurant.category' => 'required|array|exists:categories,id',
        ])['restaurant']['category'];

        $location = $request->validate([
            'restaurant.address' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $restaurant = new Restaurant();
        $restaurant->title = $request->restaurant['title'];
        $restaurant->user_id = auth()->id();
        $restaurant->phone = $request->restaurant['phone'];
        $restaurant->bank_account = $request->restaurant['bank_account'];
        $restaurant->save();

        //add location with morph to addresses table
        $address = new Address;
        $address->title = 'main';
        $address->address = $location['restaurant']['address'];
        $address->latitude = $location['latitude'];
        $address->longitude = $location['longitude'];
        $restaurant->addressInfo()->save($address);

        $schedule = $request->validate([
            'schedule' => 'array',
        ])['schedule'];

        $schedule = collect($schedule)
            ->filter(function ($item) {
            return $item['open_time'] != null && $item['close_time'] != null;
        })
            ->map(function ($item, $key) use ($restaurant) {

            $restaurant->weekSchedules()->updateOrCreate(
            ['day' => $key, 'restaurant_id' => $restaurant->id],
            ['open_time' => $item['open_time'], 'close_time' => $item['close_time']]
            );
        });

        WeekSchedule::whereNotIn('day', $schedule->keys())->where('restaurant_id', $data['restaurant']['id'])->delete();


        $categoryRestaurant = new CategoryRestaurant();
        collect($category)->map(function ($item) use ($categoryRestaurant, $restaurant) {
            $categoryRestaurant->category_id = $item;
            $categoryRestaurant->restaurant_id = $restaurant->id;
            $categoryRestaurant->save();
        });

        return json_encode(['status' => 'success', 'message' => 'Restaurant add successfully']);
    }

    public function show($id)
    {
        // TODO:show if user is owner of restaurant
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
            'restaurant.id' => 'required',
            'restaurant.title' => 'required|min:2',
            'restaurant.phone' => 'required|numeric|digits:11',
            'restaurant.status' => 'required|min:2',
            'restaurant.bank_account' => 'required|digits:16',
        ]);

        $category = $request->validate([
            'restaurant.category' => 'required|array|exists:categories,id',
        ])['restaurant']['category'];

        $location = $request->validate([
            'restaurant.address' => 'required|min:2|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $schedule = $request->validate([
            'schedule' => 'array',
        ])['schedule'];

        $schedule = collect($schedule)
            ->filter(function ($item) {
            return $item['open_time'] != null && $item['close_time'] != null;
        })
            ->map(function ($item, $key) use ($restaurant) {

            $restaurant->weekSchedules()->updateOrCreate(
            ['day' => $key, 'restaurant_id' => $restaurant->id],
            ['open_time' => $item['open_time'], 'close_time' => $item['close_time']]
            );
        });

        WeekSchedule::whereNotIn('day', $schedule->keys())->where('restaurant_id', $data['restaurant']['id'])->delete();

        $data['restaurant']['confirm'] = 'waiting';
        $data['restaurant']['status'] = 'inactive';

        CategoryRestaurant::whereNotIn('category_id', $category)->where('restaurant_id', $data['restaurant']['id'])->delete();
        foreach ($category as $row) {
            if (!CategoryRestaurant::where('category_id', $row)->where('restaurant_id', $data['restaurant']['id'])->exists()) {
                CategoryRestaurant::create(['category_id' => $row, 'restaurant_id' => $data['restaurant']['id']]);
            }
        }

        //add location with morph to addresses table
        $address = new Address;
        $address->title = 'main';
        $address->address = $location['restaurant']['address'];
        $address->latitude = $location['latitude'];
        $address->longitude = $location['longitude'];
        $restaurant->addressInfo()->update($address->toArray());

        $restaurant->update($data['restaurant']);

        return json_encode(['status' => 'success', 'message' => 'Restaurant updated']);
    }

}
