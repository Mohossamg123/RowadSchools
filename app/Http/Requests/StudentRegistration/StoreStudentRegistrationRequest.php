<?php

namespace App\Http\Requests\StudentRegistration;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:255'],

            'parent_name' => ['required', 'string', 'max:255'],

            'phone' => ['required', 'string', 'max:30'],

            'email' => ['nullable', 'email', 'max:255'],

            'gender' => ['nullable', 'in:male,female'],

            'educational_stage_id' => [
                'nullable',
                'exists:educational_stages,id',
            ],

            'grade_id' => [
                'nullable',
                'exists:grades,id',
            ],

            'notes' => ['nullable', 'string'],
        ];
    }
}
