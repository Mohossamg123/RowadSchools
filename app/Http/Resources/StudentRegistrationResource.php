<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentRegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'student_name' => $this->student_name,
            'parent_name' => $this->parent_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,

            'educational_stage_id' => $this->educational_stage_id,
            'grade_id' => $this->grade_id,

            'educational_stage' => new EducationalStageResource(
                $this->whenLoaded('educationalStage')
            ),

            'grade' => new GradeResource(
                $this->whenLoaded('grade')
            ),

            'notes' => $this->notes,
            'status' => $this->status,

            'email_notification_sent' => $this->email_notification_sent,
            'email_notification_sent_at' => $this->email_notification_sent_at,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}