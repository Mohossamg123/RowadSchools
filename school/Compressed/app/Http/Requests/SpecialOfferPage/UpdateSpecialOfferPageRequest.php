<?php

namespace App\Http\Requests\SpecialOfferPage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecialOfferPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $page = $this->route('specialOfferPage');

        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique(
                    'special_offer_pages',
                    'slug'
                )->ignore($page),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],

            'noindex' => [
                'sometimes',
                'boolean',
            ],

            'nofollow' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
