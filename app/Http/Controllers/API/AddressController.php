<?php

namespace App\Http\Controllers\API;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     //  * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $user = $request->user();

        if (empty($user->addresses->toArray())) {
            $request->merge(['is_current_location' => true]);
        }

        if ($user->addresses()->create($request->toArray())) {
            return response(['msg' => 'address added successfully'], 200);
        }
        return response()->json('hi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $addresses = $user->addresses->map(function ($address) {
            return $address->only(['id', 'title', 'address', 'latitude', 'longitude']);
        }
        );
        return response($addresses);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $assress
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $address)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
    //
    }

    /**
     * Set customer current address in storage.
     *
     * @param  \App\Models\Address  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function setCurrentAddress(Request $request, $id)
    {
        // TODO:add policy if requested id belong to user
        $addresses = $request->user()->addresses();

        try {
            $address = $request->user()->addresses()->findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return response(['msg' => ['Address NOT FOUND']], 404);
        }
        $addresses->where([['is_current_location', true]])->update(['is_current_location' => false]);
        $address->update(['is_current_location' => true]);

        return response(['msg' => ['current address updated successfully']], 404);
    }
}
