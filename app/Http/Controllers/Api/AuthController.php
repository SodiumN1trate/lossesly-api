<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' =>'required|max:50',
            'surname' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $password = $validated['password'];

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'user' => new UserResource($user)
        ]);
    }
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated)->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
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
            'user' => new UserResource($user),
            'access_token' => $token,
        ]);
    }
    public function changePassword(Request $request){
        $validated = $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if(!Hash::check($validated['old_password'], auth()->user()->password)) {
            return response()->json([
                'errors' => [
                    'error' => [
                        'Pašreizēja parole nesakrīt ar ievadīto!',
                    ],
                ],
            ], 403);
        }

        User::find(auth()->user()->id)->update([
            'password' => Hash::make($validated['password'])
        ]);
        return response()->json([
            'message' => 'Parole veiksmīgi nomainīta',
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

    public function forgotPassword(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $validated['email'])->firstOrFail();
        Mail::to($user->email)->send(new ForgotPassword($user));

        return response()->json([
            'data' => 'Jums uz e-pastu tika nosūtīta paroles maiņas adrese!'
        ]);
    }

    public function resetPassword(Request $request, User $user) {
        if (! $request->hasValidSignature()) { abort(401); }
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user->update(['password' => Hash::make($validated['password'])]);

        return response()->json([
            'data' => 'Parole veiksmīgi nomainīta'
        ]);
    }
}
