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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(UserRequest $request)
    {
        return UserResource::collection(User::filter($request->all())->get());
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if(auth()->user()->id !== $user->id && !auth()->user()->hasAnyRole(['Administrators', 'Galvenais administrators'])) {
            return response()->json([
                'data' => 'Jūs to nevarat izdarīt'
            ], 401);
        }
        $validated = $request->validated();
        $user_with_email = User::where('email', $validated['email'])->first();
        if(isset($user_with_email) && $user_with_email->id !== $user->id) {
            return response()->json([
                'errors' =>
                    [
                        'email' =>
                            [
                                'E-pasts jau ir aizņemts.'
                            ]
                    ]
            ], 422);
        }
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

    public function specialists(Request $request) {
        return UserResource::collection((User::filter($request->all())->withCount('specialities')->withCount('applications')->get())->where('specialities_count', '>', 0)->where('applications_count', '>', 0));
    }
}
