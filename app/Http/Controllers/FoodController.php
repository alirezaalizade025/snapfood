<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use App\Http\Requests\FoodRequest;

class FoodController extends Controller
{

    public function index()
    {
        return view('dashboard.food');
    }



    public function store(Request $request)
    {
        $food = $request->validate([
            'name' => 'required|min:2|unique:food,name',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'food_party_id' => 'nullable|exists:food_parties,id',
            'food_type_id' => 'required|exists:food_types,id',
        ]);

        $material = collect($request->all()['raw_materials'])->filter(function ($value) {
            return !empty($value);
        })->toArray();

        $request->merge(['raw_materials' => $material]);
        $material = $request->validate([
            'raw_materials.*' => 'required|string|min:2|max:255',
        ]);

        if ($food = Food::create($food)) {
            foreach ($material['raw_materials'] as $material) {
                RawMaterial::create(['name' => $material, 'food_id' => $food->id]);
            }
            return json_encode(['status' => 'success', 'message' => $food->name . ' added successfully.']);
        }
        return json_encode(['status' => 'success', 'message' => 'Error adding food.']);

    }


    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $food = Food::find($id);
        if (in_array('status', $request->all())) {
            if ($food->status == 'active') {
                $food->status = 'inactive';
            }
            else {
                $food->status = 'active';
            }
            $food->update(['status' => $food->status]);
            return json_encode(['status' => 'success', 'message' => $food->name . ' status updated']);
        }
        $data = $request->validate(
        [
            'name' => 'required|min:2|max:255|unique:food,name,' . $id,
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|digits:2',
            'food_party_id' => 'nullable|exists:food_parties,id',
            'food_type_id' => 'required|exists:food_types,id',
        ]
        );

        $material = collect($request->all()['raw_materials'])->filter(function ($value) {
            return !empty($value);
        })->toArray();

        $request->merge(['raw_materials' => $material]);
        $material = $request->validate([
            'raw_materials.*' => 'required|min:2|max:255',
        ]);

        if ($food->update($data)) {
            RawMaterial::whereNotIn('name', $material['raw_materials'])->where('food_id', $food->id)->delete();
            foreach ($material['raw_materials'] as $row) {
                if (!RawMaterial::where('name', $row)->where('food_id', $food->id)->exists()) {
                    RawMaterial::create(['name' => $row, 'food_id' => $food->id]);
                }
            }
            return json_encode(['status' => 'success', 'message' => $food->name . ' updated']);
        }


    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function destroy($id)
    {
        $food = Food::find($id);
        if (!is_null($food)) {
            $food->delete();
            $message = ['status' => 'success', 'message' => $food->name . ' deleted successfully'];
        }
        else {
            $message = ['status' => 'error', 'message' => $food->name . 'Can\'t delete now!'];
        }
        return json_encode($message);
    }
}
