<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return User::filter($request->all())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(UserRequest $request)
    {
        return new UserResource(User::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UserResource
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        if(isset($validated['avatar'])) {
            $avatar = $validated['avatar'];
            $validated['avatar'] = $avatar->hashName();
            $avatar->store('public/avatars');
        }
        $user->update($validated);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource($user);
    }

    public function avatar(Request $request, $user_id) {
        if (! $request->hasValidSignature()) {abort(401);}

        $path = Storage::disk('local')->path('public/avatars/') . User::find($user_id)->avatar;
        return response()->file($path);
    }
}
