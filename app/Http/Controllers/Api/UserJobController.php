<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserJobRequest;
use App\Http\Resources\UserJobResource;
use App\Models\UserJob;
use Illuminate\Http\Request;

class UserJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserJobResource::collection(UserJob::where('user_id', auth()->user()->id)->paginate(8));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserJobResource
     */
    public function store(UserJobRequest $request)
    {
        return new UserJobResource(UserJob::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserJobResource
     */
    public function show(UserJob $userJob)
    {
        return new UserJobResource($userJob);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UserJobResource
     */
    public function update(UserJobRequest $request, UserJob $userJob)
    {
        $userJob->update($request->validated());
        return new UserJobResource($userJob);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return UserJobResource
     */
    public function destroy(UserJob $userJob)
    {
        $userJob->delete();
        return new UserJobResource($userJob);
    }
}
