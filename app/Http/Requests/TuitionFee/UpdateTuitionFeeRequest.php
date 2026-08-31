<?php

namespace App\Http\Requests\TuitionFee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTuitionFeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'grade_id' => ['sometimes', 'exists:grades,id'],
            'academic_year' => ['sometimes', 'string', 'max:20'],

            'annual_fee' => ['sometimes', 'numeric', 'min:0'],
            'registration_fee' => ['nullable', 'numeric', 'min:0'],
            'cash_amount' => ['nullable', 'numeric', 'min:0'],
            'installment_amount' => ['nullable', 'numeric', 'min:0'],
            'installment_count' => ['nullable', 'integer', 'min:1'],
            'first_term_amount' => ['nullable', 'numeric', 'min:0'],
            'second_term_amount' => ['nullable', 'numeric', 'min:0'],

            'fees' => ['sometimes', 'array'],
            'fees.total' => ['sometimes', 'numeric', 'min:0'],
            'fees.cash' => ['sometimes', 'numeric', 'min:0'],
            'fees.registration' => ['sometimes', 'numeric', 'min:0'],
            'fees.installment' => ['sometimes', 'array'],
            'fees.installment.amount' => ['sometimes', 'numeric', 'min:0'],
            'fees.installment.count' => ['sometimes', 'integer', 'min:1'],
            'fees.first_term' => ['sometimes', 'numeric', 'min:0'],
            'fees.second_term' => ['sometimes', 'numeric', 'min:0'],

            'sibling_discount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
        ];
    }
}
