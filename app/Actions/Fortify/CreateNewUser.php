<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'bank_account_number' => ['required', 'integer', 'unique:users', 'digits:16'],
            'phone' => ['required', 'string', 'unique:users', 'regex:/^(\\+98|0)?9\\d{9}$/'],
            'role' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required|max:255'
        ])->validate();

        $address = DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'bank_account_number' => $input['bank_account_number'],
                'role' => $input['role'],
            ])->addresses()->create([
                'title' => 'default',
                'latitude' => $input['latitude'],
                'longitude' => $input['longitude'],
                'address' => $input['address'],
            ]);
            return $user;
        });
        DB::commit();

        return User::find($address->addressable_id);
    }
}
