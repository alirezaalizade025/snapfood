<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function addresses(Request $request)
    {
        $user = $request->user();
        $addresses = $user->contacts->map(function ($contact) {
            return $contact->only(['id', 'title', 'address', 'latitude', 'longitude']);
        }
        );
        return response()->json($addresses);
    }

}
