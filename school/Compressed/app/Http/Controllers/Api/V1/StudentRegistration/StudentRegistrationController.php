<?php

namespace App\Http\Controllers\Api\V1\StudentRegistration;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRegistration\StoreStudentRegistrationRequest;
use App\Http\Requests\StudentRegistration\UpdateStudentRegistrationRequest;
use App\Http\Resources\StudentRegistrationResource;
use App\Models\StudentRegistration;
use Illuminate\Http\JsonResponse;
use App\Mail\StudentRegistrationReceived;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class StudentRegistrationController extends Controller
{
    public function index(): JsonResponse
    {
        $registrations = StudentRegistration::with([
            'educationalStage',
            'grade',
        ])
        ->latest()
        ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => StudentRegistrationResource::collection($registrations),
        ]);
    }

    public function store(
        StoreStudentRegistrationRequest $request
    ): JsonResponse {
        $registration = StudentRegistration::create(
            $request->validated()
        );

        $registration->load([
            'educationalStage',
            'grade',
        ]);

        $adminEmail = config(
            'mail.registration_email',
            config('mail.from.address')
        );

        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(
                    new StudentRegistrationReceived($registration)
                );

                $registration->update([
                    'email_notification_sent' => true,
                    'email_notification_sent_at' => now(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Student registration email failed', [
                    'registration_id' => $registration->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Student registration submitted successfully.',
            'data' => new StudentRegistrationResource(
                $registration->fresh([
                    'educationalStage',
                    'grade',
                ])
            ),
        ], 201);
    }

    public function show(
        StudentRegistration $studentRegistration
    ): JsonResponse {
        $studentRegistration->load([
            'educationalStage',
            'grade',
        ]);

        return response()->json([
            'success' => true,
            'data' => new StudentRegistrationResource(
                $studentRegistration
            ),
        ]);
    }

    public function update(
        UpdateStudentRegistrationRequest $request,
        StudentRegistration $studentRegistration
    ): JsonResponse {
        $studentRegistration->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Student registration updated successfully.',
            'data' => new StudentRegistrationResource(
                $studentRegistration->fresh([
                    'educationalStage',
                    'grade',
                ])
            ),
        ]);
    }

    public function destroy(
        StudentRegistration $studentRegistration
    ): JsonResponse {
        $studentRegistration->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student registration deleted successfully.',
        ]);
    }
}