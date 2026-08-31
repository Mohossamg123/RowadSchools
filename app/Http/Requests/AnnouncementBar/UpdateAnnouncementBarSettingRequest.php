<?php

namespace App\Http\Requests\AnnouncementBar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementBarSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_enabled' => ['required', 'boolean'],
        ];
    }
}
