<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EducationalStage;
use App\Models\Gallery;
use App\Models\Offer;
use App\Models\StudentRegistration;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $data = [
            'users' => User::count(),

            'educational_stages' => EducationalStage::count(),

            'offers' => Offer::count(),

            'announcements' => Announcement::count(),

            'testimonials' => Testimonial::count(),

            'galleries' => Gallery::count(),

            'payment_methods' => PaymentMethod::count(),

            'student_registrations' =>
                StudentRegistration::count(),

            'pending_registrations' =>
                StudentRegistration::where(
                    'status',
                    'pending'
                )->count(),

            'approved_registrations' =>
                StudentRegistration::where(
                    'status',
                    'approved'
                )->count(),

            'recent_registrations' =>
                StudentRegistration::with([
                    'educationalStage',
                    'grade',
                ])
                ->latest()
                ->limit(5)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
