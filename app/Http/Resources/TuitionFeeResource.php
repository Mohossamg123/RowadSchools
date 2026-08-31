<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TuitionFeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'grade_id' => $this->grade_id,
            'academic_year' => $this->academic_year,

            'fees' => [
                'total' => $this->annual_fee,
                'cash' => $this->cash_amount,
                'registration' => $this->registration_fee,

                'installment' => [
                    'amount' => $this->installment_amount,
                    'count' => $this->installment_count,
                ],

                'first_term' => $this->first_term_amount,
                'second_term' => $this->second_term_amount,
            ],

            'sibling_discount' => $this->sibling_discount,

            'notes' => $this->notes,
            'status' => $this->status,

            'grade' => new GradeResource(
                $this->whenLoaded('grade')
            ),
        ];
    }
}