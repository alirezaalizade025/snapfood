<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\WeekSchedule;
use Illuminate\Http\Request;
use App\Models\CategoryRestaurant;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class RestaurantController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Restaurant::class);
        return view('dashboard.restaurant');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Restaurant::class);
        $request->validate([
            'restaurant.title' => 'required|min:2',
            'restaurant.phone' => 'required|numeric|digits:11',
            'restaurant.bank_account' => 'required|digits:16',
            'restaurant.delivery_fee' => 'required|numeric',
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
        $restaurant->delivery_fee = $request->restaurant['delivery_fee'];
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
            return $item['start'] != null && $item['end'] != null;
        })
            ->map(function ($item, $key) use ($restaurant) {

            $restaurant->weekSchedules()->updateOrCreate(
            ['day' => $key, 'restaurant_id' => $restaurant->id],
            ['start' => $item['start'], 'end' => $item['end']]
            );
        });

        WeekSchedule::whereNotIn('day', $schedule->keys())
            ->where('restaurant_id', $restaurant->id)
            ->delete();

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
        $restaurantInfo = Restaurant::where('user_id', auth()->user()->id)->get()->first();

        if ($restaurantInfo != null) {
            $this->authorize('view', $restaurantInfo);
        }

        return view('dashboard.myRestaurant', compact('restaurantInfo'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (in_array('status', $request->all())) {
            $user = User::find(auth()->id());
            if ($user->role == 'admin') {
                $this->authorize('changeConfirm', $restaurant);
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
                $this->authorize('changeStatus', $restaurant);
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
        $this->authorize('update', $restaurant);
        $data = $request->validate([
            'restaurant.id' => 'required',
            'restaurant.title' => 'required|min:2',
            'restaurant.phone' => 'required|numeric|digits:11',
            'restaurant.status' => 'required|min:2',
            'restaurant.bank_account' => 'required|digits:16',
            'restaurant.delivery_fee' => 'required|numeric',
        ]);

        $category = $request->validate([
            'restaurant.category' => 'required|array|exists:categories,id',
        ])['restaurant']['category'];

        $location = $request->validate([
            'restaurant.address' => 'required|min:2|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        if ($request->schedule) {
            $schedule = $request->validate([
                'schedule' => 'array',
            ])['schedule'];

            $schedule = collect($schedule)
                ->filter(function ($item) {
                return $item['start'] != null && $item['end'] != null;
            })
                ->map(function ($item, $key) use ($restaurant) {

                $restaurant->weekSchedules()->updateOrCreate(
                ['day' => $key, 'restaurant_id' => $restaurant->id],
                ['start' => $item['start'], 'end' => $item['end']]
                );
            });

            WeekSchedule::whereNotIn('day', $schedule->keys())->where('restaurant_id', $data['restaurant']['id'])->delete();
        }
        
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

    public function orders($id)
    {
        if (auth()->user()->restaurant) {
            $restaurant = auth()->user()->restaurant;
            if ($restaurant->confirm != 'accept') {
                return redirect('dashboard')->withErrors('You can\'t see order until your restaurant be confirmed');
            }
        }
        else {
            $restaurant = Restaurant::find($id);
            return redirect('dashboard')->withErrors('You can\'t see order until your restaurant be confirmed');
        }


        if ($restaurant != null) {
            $this->authorize('order', $restaurant);
        }


        return view('dashboard.myOrders', compact('restaurant'));

    }

    public function reports()
    {
        $restaurant = auth()->user()->restaurant;

        if ($restaurant != null) {
            $this->authorize('order', $restaurant);
        }
        else {
            return redirect('dashboard')->withErrors('Restaurant Not Found!');
        }

        $settings1 = [
            'chart_title' => 'Reports',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Cart',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_days' => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'translation_key' => 'cart',
            'continuous_time' => true,
        ];

        $chart = new LaravelChart($settings1);

        return view('dashboard.reports', compact('restaurant', 'chart'));

    }



    public function comments()
    {
        if (auth()->user()->role != 'admin') {
            if (auth()->user()->restaurant) {
                $restaurant = auth()->user()->restaurant;
                if ($restaurant->confirm != 'accept') {
                    return redirect('dashboard')->withErrors('You can\'t order until your restaurant be confirmed');
                }
            }
            else {
                $restaurant = Restaurant::find(optional(auth()->user()->restaurant)->id);
                return redirect('dashboard')->withErrors('You can\'t order until your restaurant be confirmed');
            }
        }

        return view('dashboard.comments');
    }

}
