<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'educational_stage_id' => $this->educational_stage_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sort_order' => $this->sort_order,
            'status' => $this->status,

            'educational_stage' => new EducationalStageResource(
                $this->whenLoaded('educationalStage')
            ),

            'tuition_fees' => TuitionFeeResource::collection(
                $this->whenLoaded('tuitionFees')
            ),
        ];
    }
}
