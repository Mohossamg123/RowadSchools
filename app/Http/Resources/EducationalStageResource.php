<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationalStageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'icon' => $this->icon,
            'age_from' => $this->age_from,
            'age_to' => $this->age_to,
            'features' => $this->features ?? [],
            'sort_order' => $this->sort_order,
            'status' => $this->status,

            'grades' => GradeResource::collection(
                $this->whenLoaded('grades')
            ),
        ];
    }
}
