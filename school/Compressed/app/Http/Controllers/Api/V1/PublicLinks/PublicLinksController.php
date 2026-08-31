<?php

namespace App\Http\Controllers\Api\V1\PublicLinks;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;

class PublicLinksController extends Controller
{
    public function index(): JsonResponse
    {
        $links = SocialLink::where('status', true)
            ->orderBy('sort_order')
            ->get();

            $settings = Setting::whereIn('key', [
    'school_name',
    'admissions_phone',
    'management_phone',
    'whatsapp',
    'email',
    'address',
])->pluck('value', 'key');

        return response()->json([
            'success' => true,
            'data' => [
                'school_name' => $settings['school_name'] ?? null,

            'links' => $links,

                'contact' => [
    'admissions_phone' => $settings['admissions_phone'] ?? null,
    'management_phone' => $settings['management_phone'] ?? null,
    'whatsapp' => $settings['whatsapp'] ?? null,
    'email' => $settings['email'] ?? null,
    'address' => $settings['address'] ?? null,
],
            ],
        ]);
    }
}
