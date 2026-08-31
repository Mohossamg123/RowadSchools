<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:pages,slug',
            ],

            'content' => ['nullable', 'string'],

            'meta_title' => ['nullable', 'string', 'max:255'],

            'meta_description' => ['nullable', 'string'],

            'is_published' => ['sometimes', 'boolean'],

            'is_indexable' => ['sometimes', 'boolean'],
        ];
    }
}
