<?php

namespace App\Http\Controllers\Api\New;

use App\Http\Controllers\Controller;
use App\Http\Resources\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return response()->json(['message' => 'User registered successfully.']);
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
//            $user = Auth::user();
            return response()->json(['message' => 'User login successfully.']);
        }
        return response()->json(['message' => 'Invalid credential'], 401);
    }

    public function logout() {
        Auth::logout();
        return response()->json(['message' => 'User successfully signed out.']);
    }
}
