<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'job_name'=>$this->job_name,
            'job_description'=>$this->job_description,
            'user_id'=>$this->user_id,
            'expert_id'=>$this->expert_id,
            'status_id'=>$this->status_id,
            'started'=>$this->started,
            'end'=>$this->end
        ];
    }
}
