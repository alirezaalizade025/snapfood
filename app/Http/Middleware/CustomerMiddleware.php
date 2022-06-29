<?php

namespace App\Http\Middleware;

use Closure;
use IlluminateHttpRequest;
use Illuminate\Http\Request;
use IlluminateSupportFacadesAuth;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role != 'customer') {
            return $next($request);
        }
        else {
            return redirect('/');
        }

    }
}
