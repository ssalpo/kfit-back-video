<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutResource extends JsonResource
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
            'title' => $this->title,
            'source_type' => $this->source_type,
            'source_id' => $this->source_id,
            'is_public' => $this->is_public,
            'progress' => $this->when($this->clientProgress, new ProgressResource($this->clientProgress)),
            'recommendations' => self::collection($this->whenLoaded('recommendations'))
        ];
    }
}
