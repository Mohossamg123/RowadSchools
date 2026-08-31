<?php

namespace App\Http\Requests\EducationalStage;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationalStageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:educational_stages,slug'],
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
