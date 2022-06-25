<?php

namespace App\Http\Controllers\API;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

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
        $address = new Address;

        if ($user->addresses()->create($request->toArray())) {
            // return response()->json(['success', 'address add successfully']);
            return response(['status' => 'success', 'message' => 'address add successfully'], 200);
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
}
