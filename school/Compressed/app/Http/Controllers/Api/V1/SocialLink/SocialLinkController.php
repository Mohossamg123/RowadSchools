<?php

namespace App\Http\Controllers\Api\V1\SocialLink;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialLink\StoreSocialLinkRequest;
use App\Http\Requests\SocialLink\UpdateSocialLinkRequest;
use App\Http\Resources\SocialLinkResource;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;

class SocialLinkController extends Controller
{
    public function index(): JsonResponse
    {
        $links = SocialLink::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => SocialLinkResource::collection($links),
        ]);
    }

    public function store(StoreSocialLinkRequest $request): JsonResponse
    {
        $link = SocialLink::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social link created successfully.',
            'data' => new SocialLinkResource($link),
        ], 201);
    }

    public function show(SocialLink $socialLink): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new SocialLinkResource($socialLink),
        ]);
    }

    public function update(
        UpdateSocialLinkRequest $request,
        SocialLink $socialLink
    ): JsonResponse {
        $socialLink->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social link updated successfully.',
            'data' => new SocialLinkResource($socialLink),
        ]);
    }


    public function publicLinks(): JsonResponse
{
    $links = SocialLink::query()
        ->where('status', true)
        ->orderBy('sort_order')
        ->get();

    return response()->json([
        'success' => true,
        'data' => SocialLinkResource::collection($links),
    ]);
}

    public function destroy(SocialLink $socialLink): JsonResponse
    {
        $socialLink->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social link deleted successfully.',
        ]);
    }
}
