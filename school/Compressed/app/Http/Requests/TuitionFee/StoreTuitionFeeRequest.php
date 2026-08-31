<?php

namespace App\Http\Requests\TuitionFee;

use Illuminate\Foundation\Http\FormRequest;

class StoreTuitionFeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

  public function rules(): array
{
    return [
        'grade_id' => ['required', 'exists:grades,id'],

        'academic_year' => ['required', 'string', 'max:20'],

        'annual_fee' => [
            'required',
            'numeric',
            'min:0',
        ],

        'registration_fee' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'cash_amount' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'installment_amount' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'installment_count' => [
            'nullable',
            'integer',
            'min:1',
        ],

        'first_term_amount' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'second_term_amount' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'sibling_discount' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'notes' => ['nullable', 'string'],

        'status' => ['sometimes', 'boolean'],
    ];
}
}
