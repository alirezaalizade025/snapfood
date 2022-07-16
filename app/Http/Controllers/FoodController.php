<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Restaurant;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\FoodRequest;

class FoodController extends Controller
{

    public function index()
    {
        if (is_null($restaurant = Restaurant::where('user_id', auth()->id())->get()->first()) && auth()->user()->role != 'admin') {
            return redirect('dashboard')->withErrors('You must create a restaurant first');
        }
        if (auth()->user()->role != 'admin' && $restaurant->confirm != 'accept') {
            return redirect('dashboard')->withErrors('Your restaurant is not confirmed yet');
        }

        return view('dashboard.food');
    }



    public function store(Request $request)
    {
        $this->authorize('create', Food::class);
        $food = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique_food_name:food,name,restaurant_id, ' . Restaurant::where('user_id', auth()->id())->get()->first()->id],
            'price' => 'required|numeric',
            'discount' => 'sometimes|numeric',
            'food_party_id' => 'nullable|exists:food_parties,id',
            'category_id' => 'required|exists:categories,id',
        ],
        ['unique_food_name' => 'Food name already exists.']);

        $material = collect($request->all()['raw_materials'])->filter(function ($value) {
            return !empty($value);
        })->toArray();

        $request->merge(['raw_materials' => $material]);
        $material = $request->validate([
            'raw_materials.*' => 'required|string|min:2|max:255',
        ]);

        $restaurant = Restaurant::where('user_id', auth()->id())->get()->first();
        if (!is_null($restaurant)) {
            $food['restaurant_id'] = $restaurant->id;
            if ($food = Food::create($food)) {
                if (!empty($material)) {
                    foreach ($material['raw_materials'] as $material) {
                        RawMaterial::create(['name' => $material, 'food_id' => $food->id]);
                    }
                }
                return json_encode(['status' => 'success', 'message' => $food->name . ' added successfully.', 'id' => $food->id]);
            }
        }
        return json_encode(['status' => 'success', 'message' => 'Error in adding food.']);

    }


    public function update(Request $request, $id)
    {
        $food = Food::find($id);

        $this->authorize('update', $food);

        if (in_array('status', $request->all())) {
            if (auth()->user()->role == 'admin') {
                if ($food->status == 'active') {
                    if ($food->confirm == 'accept') {
                        $food->confirm = 'denied';
                    }
                    else {
                        $food->confirm = 'accept';
                    }
                }
                else {
                    $food->confirm = 'denied';
                }
                $column = 'confirm';

            }
            elseif (auth()->user()->role == 'restaurant') {
                if ($food->status == 'active') {
                    $food->status = 'inactive';
                }
                else {
                    $food->status = 'active';
                }
                $column = 'status';
            }
            $food->save();
            return json_encode(['status' => 'success', 'message' => $food->name . ' ' . $column . ' updated', 'id' => $food->id]);
        }
        $data = $request->validate(
        [
            'name' => 'required|min:2|max:255|unique_food_name:food,name,restaurant_id,' . $id,
            'price' => 'required|numeric',
            'discount' => 'sometimes|numeric',
            'food_party_id' => 'nullable|exists:food_parties,id',
            'category_id' => 'required|exists:categories,id',
        ]
        );

        $material = collect($request->all()['raw_materials'])->filter(function ($value) {
            return !empty($value);
        })->toArray();

        $request->merge(['raw_materials' => $material]);
        $material = $request->validate([
            'raw_materials.*' => 'required|min:2|max:255',
        ]);
        $data['status'] = 'inactive';
        $data['confirm'] = 'waiting';

        if ($food->update($data)) {
            if (!empty($material)) {
                RawMaterial::whereNotIn('name', $material['raw_materials'])->where('food_id', $food->id)->delete();
                foreach ($material['raw_materials'] as $row) {
                    if (!RawMaterial::where('name', $row)->where('food_id', $food->id)->exists()) {
                        RawMaterial::create(['name' => $row, 'food_id' => $food->id]);
                    }
                }
            }
            return json_encode(['status' => 'success', 'message' => $food->name . ' updated', 'id' => $food->id, 'image' => $food->image]);
        }


    }

    public function destroy($id)
    {
        $food = Food::find($id);

        $this->authorize('delete', $food);

        if (!is_null($food)) {
            $food->delete();
            $message = ['status' => 'success', 'message' => $food->name . ' deleted successfully'];
        }
        else {
            $message = ['status' => 'error', 'message' => 'Can\'t delete now!'];
        }
        return json_encode($message);
    }
}
