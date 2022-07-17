<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\FoodParty;
use Illuminate\Http\Request;

class FoodPartyController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', FoodParty::class);
        return view('dashboard.foodParty');
    }

    public function store(Request $request)
    {
        $this->authorize('create', FoodParty::class);
        $data = $request->validate([
            'name' => 'required|min:2|max:255|unique:food_parties',
            'discount' => 'required|numeric|between:0,99.99',
            'start_at' => 'required|date|after:now',
            'expires_at' => 'required|date|after:start_at'
        ]);
        $data['start_at'] = Carbon::parse($data['start_at'])->format('Y-m-d H:i:s');
        $data['expires_at'] = Carbon::parse($data['expires_at'])->format('Y-m-d H:i:s');

        if (FoodParty::create($data)) {
            return json_encode(['status' => 'success', 'message' => $data['name'] . ' add successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $data['name'] . ' can\'t  add now!']);

    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', FoodParty::class);
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
            'discount' => 'required|numeric|between:0,99.99',
            'start_at' => 'required|date',
            'expires_at' => 'required|date|after:start_at'
        ]);
        $data['start_at'] = Carbon::parse($data['start_at'])->format('Y-m-d H:i:s');
        $data['expires_at'] = Carbon::parse($data['expires_at'])->format('Y-m-d H:i:s');

        if ($foodParty->update($data)) {
            return json_encode(['status' => 'success', 'message' => $data['name'] . ' updated successfully']);
        }
        return json_encode(['status' => 'error', 'message' => $data['name'] . ' can\'t be changed']);
    }

    public function destroy($id)
    {
        $this->authorize('delete', FoodParty::class);
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
