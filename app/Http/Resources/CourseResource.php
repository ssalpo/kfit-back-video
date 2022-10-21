<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cover' => $this->cover,
            'duration' => $this->duration,
            'level' => $this->level,
            'muscles' => $this->muscles,
            'type' => $this->type,
            'description' => $this->description,
            'progress' => $this->when($this->clientProgress, new ProgressResource($this->clientProgress)),
            'recommendations' => self::collection($this->whenLoaded('recommendations')),
            'rating' => $this->rating,
            'active' => $this->active,
            'is_public' => $this->is_public,
            'course_type' => $this->course_type,
            'trainer_id' => $this->trainer_id,
            'direction' => $this->direction,
            'active_area' => $this->active_area,
            'inventory' => $this->inventory,
            'pulse_zone' => $this->pulse_zone,
        ];
    }
}
