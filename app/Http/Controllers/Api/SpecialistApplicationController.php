<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialistApplicationRequest;
use App\Http\Resources\SpecialistApplicationResource;
use App\Models\Attachment;
use App\Models\SpecialistApplication;
use Illuminate\Http\Request;

class SpecialistApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SpecialistApplicationResource::collection(SpecialistApplication::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return SpecialistApplicationResource
     */
    public function store(SpecialistApplicationRequest $request)
    {
        $validated = $request->validated();
        $app = SpecialistApplication::create($validated);
        if(isset($validated['attachments'])) {
            foreach ($validated['attachments'] as $attachment) {
                $file = $attachment->hashName();
                $attachment->store('public/attachments');
                $attach = Attachment::create([
                    'name' => $file,
                ]);
                $app->attach($attach->id);
            }
        }
        return new SpecialistApplicationResource($app);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return SpecialistApplicationResource
     */
    public function show($id)
    {
        $app = SpecialistApplication::find($id);
        return new SpecialistApplicationResource($app);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return SpecialistApplicationResource
     */
    public function update(SpecialistApplicationRequest $request, $id)
    {
        $app = SpecialistApplication::find($id);
        $app->update($request->validated());
        return new SpecialistApplicationResource($app);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return SpecialistApplicationResource
     */
    public function destroy($id)
    {
        $app = SpecialistApplication::find($id);
        $app->delete();
        return new SpecialistApplicationResource($app);
    }
}