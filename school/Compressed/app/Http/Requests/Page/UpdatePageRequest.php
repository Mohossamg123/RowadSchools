<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $page = $this->route('page');

        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('pages', 'slug')->ignore($page),
            ],

            'content' => ['nullable', 'string'],

            'meta_title' => ['nullable', 'string', 'max:255'],

            'meta_description' => ['nullable', 'string'],

            'is_published' => ['sometimes', 'boolean'],

            'is_indexable' => ['sometimes', 'boolean'],
        ];
    }
}
