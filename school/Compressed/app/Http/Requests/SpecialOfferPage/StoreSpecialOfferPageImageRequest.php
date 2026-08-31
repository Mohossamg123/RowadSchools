<?php

namespace App\Http\Requests\SpecialOfferPage;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialOfferPageImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'special_offer_page_id' => [
                'required',
                'exists:special_offer_pages,id',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }
}
