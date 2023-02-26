<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
            'review' => $this->review,
            'user' => new UserResource($this->user()->select(['name', 'surname', 'avatar', 'rating'])->first()),
            'created_at' => (new \Carbon\Carbon($this->created_at))->format('d-m-Y H:m'),
        ];
    }
}
