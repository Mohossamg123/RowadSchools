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
use App\Models\LinkClick;
use App\Models\SiteVisit;
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

            'site_visits_this_month' =>
                SiteVisit::whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ])->count(),

            'registrations_this_month' =>
                StudentRegistration::whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ])->count(),

            'active_offers' =>
                Offer::query()
                    ->where('status', true)
                    ->where(function ($query) {
                        $query->whereNull('start_date')
                            ->orWhere('start_date', '<=', now());
                    })
                    ->where(function ($query) {
                        $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now());
                    })
                    ->count(),

            'link_clicks_this_month' =>
                LinkClick::whereBetween('clicked_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ])->count(),

            'activity_summary' => [
                'registration_requests_this_month' =>
                    StudentRegistration::whereBetween('created_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth(),
                    ])->count(),

                'active_offers' =>
                    Offer::query()
                        ->where('status', true)
                        ->where(function ($query) {
                            $query->whereNull('start_date')
                                ->orWhere('start_date', '<=', now());
                        })
                        ->where(function ($query) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                        })
                        ->count(),

                'link_page_clicks_this_month' =>
                    LinkClick::whereBetween('clicked_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth(),
                    ])->count(),

                'site_visits_this_month' =>
                    SiteVisit::whereBetween('created_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth(),
                    ])->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}