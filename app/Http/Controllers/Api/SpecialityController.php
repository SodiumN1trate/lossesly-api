<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialityRequest;
use App\Http\Resources\SpecialityResource;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SpecialityResource::Collection(Speciality::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialityRequest $request)
    {
        $speciality = Speciality::create($request->validated());
        return new SpecialityResource($speciality);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Speciality $speciality)
    {
        return new SpecialityResource($speciality);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialityRequest $request, Speciality $speciality)
    {

        $speciality->update($request->validated());
        return new SpecialityResource($speciality);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speciality $speciality)
    {
        $speciality->delete();
        return new SpecialityResource($speciality);
    }
}
