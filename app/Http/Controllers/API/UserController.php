<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, $id)
    {
        if($request->user()->id != $id) {
            return response()->json(['error' => 'You can only update your own account.'], 403);
        }
        $request->password = $request->password ? bcrypt($request->password) : $request->password;

        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['msg' => 'Account information updated'], 200);
    }

}
