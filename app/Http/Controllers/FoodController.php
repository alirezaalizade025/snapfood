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
            'name' => 'required|min:2',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'food_party_id' => 'nullable|exists:food_parties,id',
            'food_type_id' => 'required|exists:food_types,id',
        ]);
        $material = $request->validate([
            'raw_material' => 'required|min:2|max:255',
        ]);
        $material = trim($material['raw_material']);
        $material = explode(',', $material);


        if ($food = Food::create($food)) {
            foreach ($material as $row) {
                RawMaterial::create(['food_id' => $food->id, 'name' => $row]);
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
        $request->validate(
        [
            'name' => 'required|min:2|max:255',
            'price' => 'required|numeric',
            'discount' => 'required|numeric|digits:2',
            'food_party_id' => 'nullable|exists:food_parties,id',
            'food_type_id' => 'nullable|exists:food_types,id',
        ]
        );
        if ($food->update($request->all())) {
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
