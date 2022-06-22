<?php

namespace App\Http\Controllers;

use App\Models\FoodParty;
use Illuminate\Http\Request;

class FoodPartyController extends Controller
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:255|unique:food_parties',
            'discount' => 'required|numeric|between:0,99.99'
        ]);


        if (FoodParty::create($data)) {
            return json_encode(['status' => 'success', 'message' => $data['name'] . ' add successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $data['name'] . ' can\'t  add now!']);

    }

    public function show($id)
    {
    //
    }

    public function update(Request $request, $id)
    {
        $foodParty = FoodParty::find($id);
        if (in_array('status', $request->all())) {
            if ($foodParty->status == 'active') {
                $foodParty->status = 'inactive';
            }
            else {
                $foodParty->status = 'active';
            }
            $foodParty->update();
            return json_encode(['status' => 'success', 'message' => $foodParty->name . ' status updated']);
        }

        $data = $request->validate([
            'name' => 'required|min:2|max:255|unique:food_parties,name,' . $id,
            'discount' => 'required|numeric|between:0,99.99'
        ]);

        if ($foodParty->update($data)) {
            return json_encode(['status' => 'success', 'message' => $data['name'] . ' updated successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $data['name'] . ' can\'t be changed']);
    }

    public function destroy($id)
    {
        $foodParty = FoodParty::find($id);
        if (!is_null($foodParty)) {
            $foodParty->delete();
            $message = ['status' => 'success', 'message' => $foodParty->name . ' deleted successfully'];
        }
        else {
            $message = ['status' => 'error', 'message' => 'Can\'t delete now!'];
        }
        return json_encode($message);
    }
}
