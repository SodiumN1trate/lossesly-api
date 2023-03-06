<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobCancelResource extends JsonResource
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
            'user_job_id' => $this->userJob,
            'reason' => $this->reason,
            'created_at' => (new \Carbon\Carbon($this->created_at))->format('d-m-Y'),
        ];
    }
}
