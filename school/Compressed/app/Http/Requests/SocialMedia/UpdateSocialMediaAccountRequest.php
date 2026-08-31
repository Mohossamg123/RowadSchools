<?php

namespace App\Http\Requests\SocialMedia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSocialMediaAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'platform' => [
                'sometimes',
                Rule::in([
                    'instagram',
                    'x',
                ]),
            ],

            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'url' => [
                'sometimes',
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
