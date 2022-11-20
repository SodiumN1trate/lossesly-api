<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name'=> 'required',
            'surname'=>'required',
            'email'=>'required|email',
            'birthday'=>'required',
            'location'=>'required',
            'about_me'=>'required',
            'is_expert'=>'required',
            'password'=>'required',
            'gender_id'=>'required',
        ]);
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        return response()->json([
            'data' => $user
        ]);
    }
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'data' => 'Nepareizi ievadīti dati'
            ]);
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
