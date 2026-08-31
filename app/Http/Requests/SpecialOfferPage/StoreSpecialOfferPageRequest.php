<?php

namespace App\Http\Requests\SpecialOfferPage;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialOfferPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                'unique:special_offer_pages,slug',
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
