<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' =>'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $password = $validated['password'];

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if (!Auth::attempt(['email' => $user->email, 'password' => $password])) {
            return response()->json([
                'errors' => [
                    'error' => [
                        'Tāds lietotājs neeksistē!',
                    ],
                ],
            ], 403);
        }

        $token = $user->createToken('accessToken')->accessToken;

        return response()->json([
            'user' => new UserResource(auth()->user()),
            'access_token' => $token,
        ]);
    }
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'errors' => [
                    'error' => [
                        'Tāds lietotājs neeksistē!',
                    ],
                ],
            ], 403);
        }

        $token = auth()->user()->createToken('accessToken')->accessToken;
        return response()->json([
            'user' => new UserResource(auth()->user()),
            'access_token' => $token,
        ]);
    }

    public function logout() {
        auth()->user()->token()->revoke();

        return response()->json([
            'message' => [
                'type' => 'success',
                'data' => 'Veiksmīga izrakstīšanās.'
            ]
        ]);
    }

    public function user() {
        return response()->json(new UserResource(auth()->user()));
    }
}
