<?php

namespace App\Http\Requests\TuitionFee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTuitionFeeSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_enabled' => ['sometimes', 'boolean'],
            'seo_indexable' => ['sometimes', 'boolean'],
        ];
    }
}
