<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class AuthController extends Controller
{

    /**
     *
     * @see: https://laravel.com/docs/7.x/sanctum#issuing-mobile-api-tokens
     *
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'status_code'  => 200,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
}
