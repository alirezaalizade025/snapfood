<?php

namespace App\Http\Controllers\API;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Util\Type;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $this->authorize('viewAny', Address::class);
        $user = auth()->user();
        $addresses = $user->addresses;

        return count($addresses) != 0 ?AddressResource::collection($addresses) : response()->json(['msg' => 'No addresses found'], 404);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $user = auth()->user();
        $this->authorize('create', Address::class);

        if (empty($user->addresses->toArray())) {
            $request->merge(['is_current_location' => true]);
        }

        if ($user->addresses()->create($request->toArray())) {
            return response(['msg' => 'address added successfully'], 200);
        }
        return response(['msg' => 'Can\'t add address now'], 404);

    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Address  $address
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Request $request)
    // {
    // //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \App\Http\Requests\UpdateContactRequest  $request
    //  * @param  \App\Models\Address  $address
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(UpdateContactRequest $request, Contact $address)
    // {
    // //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Address  $address
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Address $address)
    // {
    // //
    // }

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
        $this->authorize('update', $address);
        $addresses->where([['is_current_location', true]])->update(['is_current_location' => false]);
        $address->update(['is_current_location' => true]);

        return response(['msg' => ['current address updated successfully']], 404);
    }
}
