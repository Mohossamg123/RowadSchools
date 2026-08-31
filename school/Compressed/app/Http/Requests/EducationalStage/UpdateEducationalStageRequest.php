<?php

namespace App\Http\Requests\EducationalStage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEducationalStageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $stage = $this->route('educationalStage');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('educational_stages', 'slug')->ignore($stage),
            ],

            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'age_from' => ['nullable', 'integer', 'min:0', 'max:25'],
            'age_to' => ['nullable', 'integer', 'min:0', 'max:25', 'gte:age_from'],
            'features' => ['nullable', 'array', 'max:8'],
            'features.*' => ['string', 'max:255'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'boolean'],
        ];
    }
}
