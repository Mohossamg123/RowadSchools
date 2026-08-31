<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\EducationalStageResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\HomepageFeatureResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\SocialLinkResource;
use App\Http\Resources\TestimonialResource;
use App\Models\Announcement;
use App\Models\EducationalStage;
use App\Models\Gallery;
use App\Models\HomepageFeature;
use App\Models\Offer;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $data = [
            'homepage_features' => HomepageFeatureResource::collection(
                HomepageFeature::query()
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->get()
            ),

            'stages' => EducationalStageResource::collection(
                EducationalStage::with('grades')
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->get()
            ),

            'offers' => OfferResource::collection(
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
                    ->orderBy('sort_order')
                    ->get()
            ),

            'announcements' => AnnouncementResource::collection(
                Announcement::query()
                    ->where('status', true)
                    ->where(function ($query) {
                        $query->whereNull('start_date')
                            ->orWhere('start_date', '<=', now());
                    })
                    ->where(function ($query) {
                        $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now());
                    })
                    ->orderBy('sort_order')
                    ->get()
            ),

            'testimonials' => TestimonialResource::collection(
                Testimonial::query()
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->get()
            ),

            'gallery' => GalleryResource::collection(
                Gallery::with('images')
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->get()
            ),

            'payment_methods' => PaymentMethodResource::collection(
                PaymentMethod::query()
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->get()
            ),

            'social_links' => SocialLinkResource::collection(
                SocialLink::query()
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->get()
            ),

            'settings' => Setting::query()
                ->get()
                ->groupBy('group')
                ->map(function ($settings) {
                    return $settings->pluck('value', 'key');
                }),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
