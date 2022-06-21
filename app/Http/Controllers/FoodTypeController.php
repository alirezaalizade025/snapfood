<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodType;
use App\Http\Livewire\RestaurantCreate;

class FoodTypeController extends Controller
{

    public function index()
    {
        return view('dashboard.foodType');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|min:2'
        ]);

        if (FoodType::create(['name' => $data['type']])) {
            return json_encode(['status' => 'success', 'message' => 'Food type add successfully']);
        }
        return json_encode(['status' => 'error', 'message' => 'Food type can\'t add now!']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'type' => 'required|min:2'
        ]);

        $foodType = FoodType::find($id);
        if ($foodType->update(['name' => $data['type']])) {
            return json_encode(['status' => 'success', 'message' => $foodType->name . 'Food type update successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $foodType->name . 'Food type can\'t update now!']);
    }


    public function destroy($id)
    {
        if ($food = FoodType::find($id)->delete()) {
            return json_encode(['status' => 'success', 'message' => 'Food type update successfully']);
        }
        return json_encode(['status' => 'error', 'message' => 'Food type can\'t update now!']);
    }
}
