<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'bank_account_number' => ['required', 'integer', 'unique:users', 'digits:16'],
            'phone' => ['required', 'string', 'unique:users', 'regex:/^(\\+98|0)?9\\d{9}$/'],
            'address' => ['required', 'string', 'max:255'],
            'location_title' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],

        ]);

        // hash password
        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        $user->addresses()->create([
            'title' => $request->location_title,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response([
            'message' => 'User created successfully',
            'token' => $user->createToken('HasApiTokens')->plainTextToken
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only(['email', 'password']))) {
            return response(['error' => 'Unauthorized'], 401);
        }

        return response([
            'message' => 'User logged in successfully',
            'token' => auth()->user()->createToken('HasApiTokens')->plainTextToken
        ]);

    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'User logged out successfully']);
    }

}
