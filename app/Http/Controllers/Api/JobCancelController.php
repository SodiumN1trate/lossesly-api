<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCancelRequest;
use App\Http\Resources\JobCancelResource;
use App\Models\JobCancel;
use Illuminate\Http\Request;

class JobCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return JobCancelResource::Collection(JobCancel::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JobCancelResource
     */
    public function store(JobCancelRequest $request)
    {
        $jobCancel = JobCancel::create($request->validated());
        return new JobCancelResource($jobCancel);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JobCancelResource
     */
    public function show(JobCancel $jobCancel)
    {
        return new JobCancelResource($jobCancel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JobCancelResource
     */
    public function update(JobCancelRequest $request, JobCancel $jobCancel)
    {

        $jobCancel->update($request->validated());
        return new JobCancelResource($jobCancel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JobCancelResource
     */
    public function destroy(JobCancel $jobCancel)
    {
        $jobCancel->delete();
        return new JobCancelResource($jobCancel);
    }
}
