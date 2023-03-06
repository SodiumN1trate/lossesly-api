<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'surname'=> $this->surname,
            'avatar' => isset($this->avatar) ? URL::signedRoute('avatar', ['user_id' => $this->id]) : 'https://www.w3schools.com/w3images/avatar2.png',
            'email' => $this->email,
            'birthday' => $this->birthday,
            'location' => $this->location,
            'about_me' => $this->about_me,
            'is_expert' => $this->is_expert,
            'gender_id' => $this->gender_id,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'specialities' => $this->specialities,
            'applications' => new SpecialistApplicationResource($this->applications[0] ?? null),
//            'user_jobs' => UserJobResource::collection($this->userJobs),
//            'expert_jobs' => UserJobResource::collection($this->expertJobs),
//            'comments' => $this->comments,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions(),
        ];
    }
}
