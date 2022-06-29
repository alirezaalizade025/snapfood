<?php
namespace App\Http\Responses;
use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;
class LoginResponse implements ContractsLoginResponse
{
    public function toResponse($request)
    {
        if (auth()->user()->role == 'customer') {
            return redirect()->intended(config('fortify.home'));
        }
        return redirect()->intended(config('fortify.dashboard'));
    }
}