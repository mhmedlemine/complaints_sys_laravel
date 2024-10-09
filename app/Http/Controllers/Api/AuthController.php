<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'phonenumber' => 'required|string|max:15|unique:users',
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'phonenumber' => $request->phonenumber,
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phonenumber' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::Where('phonenumber', $request->phonenumber)
                    ->first();
                    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Vos données sont incorrectes.'],
            ]);
        }

        $roles = $user->roles()->pluck('name');

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token, 'roles' => $roles], 200);
    }
}