<?php

namespace App\Http\Controllers\API;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RestaurantAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $restaurant = Restaurant::where([['id', $id], ['confirm', 'accept']])->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => 'restaurant not found'], 404);
        }

        $days = ['saturday' => 1, 'sunday' => 2, 'monday' => 3, 'tuesday' => 4, 'wednesday' => 5, 'thursday' => 6, 'friday' => 7];
        $restaurant = [
            'id' => $restaurant->id,
            'title' => $restaurant->title,
            'type' => $restaurant->foodType->name,
            'address' => $restaurant->addresses()->get(['address', 'latitude', 'longitude'])->first(),
            // TODO:uncomment phone
            // 'phone' => $restaurant->phone,
            'is_open' => $restaurant->status == 'active' ? true : false,
            'image' => $restaurant->image->path,
            'score' => number_format($restaurant->comments()->avg('score'), 2),
            'comment_count' => $restaurant->comments()->count(),
            'schedule' => $restaurant->weekSchedules->keyBy('day')->map(function ($item) {
            return [
            'start' => $item->open_time,
            'end' => $item->close_time
            ];
        })
        ];

        // for add null if no schedule for that day
        collect($days)->diffKeys($restaurant['schedule'])->each(function ($item, $key) use ($restaurant) {
            $restaurant['schedule'][$key] = null;
        });
        // sort by day order in week schedule
        $restaurant['schedule'] = $restaurant['schedule']->sortBy(fn($val, $key) => $days[$key]);

        return response($restaurant, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
    //
    }
}
