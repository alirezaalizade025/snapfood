<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, $id)
    {
        $user = auth()->user();
        $this->authorize('update', $user);
        
        if (isset($request['password'])) {
            $request['password'] = bcrypt($request->password);
        }

        $user->update($request->all());
        return response()->json(['msg' => 'Account information updated'], 200);
    }


    public function profile()
    {
        $user = User::with(['addresses', 'image'])->find(auth()->user()->id);
        return response($user);
    }

}
