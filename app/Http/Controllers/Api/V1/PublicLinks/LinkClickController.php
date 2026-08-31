<?php

namespace App\Http\Controllers\Api\V1\PublicLinks;

use App\Http\Controllers\Controller;
use App\Models\LinkClick;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;

class LinkClickController extends Controller
{
    public function store(SocialLink $socialLink): JsonResponse
    {
        if (!$socialLink->status) {
            return response()->json([
                'success' => false,
                'message' => 'Link is inactive.',
            ], 404);
        }

        LinkClick::create([
            'social_link_id' => $socialLink->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Click recorded successfully.',
        ]);
    }
}