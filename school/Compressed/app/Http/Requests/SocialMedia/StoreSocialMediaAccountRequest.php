<?php

namespace App\Http\Requests\SocialMedia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSocialMediaAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'platform' => [
                'required',
                Rule::in([
                    'instagram',
                    'x',
                ]),
            ],

            'username' => [
                'required',
                'string',
                'max:255',
            ],

            'url' => [
                'required',
                'url',
                'max:1000',
            ],

            'access_token' => [
                'nullable',
                'string',
            ],

            'status' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
