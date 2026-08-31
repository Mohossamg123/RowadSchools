<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => ['nullable', 'string'],
            'type' => ['sometimes', 'string', 'max:50'],
            'group' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
