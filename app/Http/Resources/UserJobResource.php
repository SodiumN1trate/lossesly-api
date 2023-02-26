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
            'id' => $this->id,
            'job_name' => $this->job_name,
            'job_description' => $this->job_description,
            'user_id' => new UserResource($this->user),
            'expert' => new UserResource($this->expert),
            'status' => $this->status_id,
            'started' => $this->started,
            'price' => $this->price,
            'end' => $this->end,
            'review' => $this->review,
            'attachments' => UserJobAttachmentResource::collection($this->attachments),
        ];
    }
}
