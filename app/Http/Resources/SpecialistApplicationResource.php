<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialistApplicationResource extends JsonResource
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
            'speciality' => $this->speciality,
            'experience' => $this->experience,
            'attachments' => AttachmentResource::collection($this->attachments),
            'status' => $this->status,
            'user_id' => $this->user,
            'created_at' => (new \Carbon\Carbon($this->created_at))->format('d-m-Y'),
        ];
    }
}
