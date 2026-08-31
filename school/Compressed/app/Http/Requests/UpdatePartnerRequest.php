<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'website' => [
                'sometimes',
                'nullable',
                'url',
                'max:2048',
            ],

            'logo' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:5120',
            ],

            'icon' => [
                'sometimes',
                'nullable',
                'string',
                'max:100',
            ],

            'sort_order' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'status' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
