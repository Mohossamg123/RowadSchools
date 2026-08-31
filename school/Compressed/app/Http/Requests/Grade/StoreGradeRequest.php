<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'educational_stage_id' => [
                'required',
                'exists:educational_stages,id',
            ],

            'name' => ['required', 'string', 'max:255'],

            'slug' => ['required', 'string', 'max:255'],

            'sort_order' => ['sometimes', 'integer', 'min:0'],

            'status' => ['sometimes', 'boolean'],
        ];
    }
}
