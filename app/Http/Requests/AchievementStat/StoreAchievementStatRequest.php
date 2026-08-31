<?php

namespace App\Http\Requests\AchievementStat;

use Illuminate\Foundation\Http\FormRequest;

class StoreAchievementStatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon' => ['nullable', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:50'],
            'label' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'boolean'],
        ];
    }
}
