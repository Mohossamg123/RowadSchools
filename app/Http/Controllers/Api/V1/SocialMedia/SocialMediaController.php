<?php

namespace App\Http\Controllers\Api\V1\SocialMedia;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialMedia\StoreSocialMediaAccountRequest;
use App\Http\Requests\SocialMedia\UpdateSocialMediaAccountRequest;
use App\Http\Resources\SocialMediaAccountResource;
use App\Models\SocialMediaAccount;
use Illuminate\Http\JsonResponse;

class SocialMediaController extends Controller
{
    public function index(): JsonResponse
    {
        $accounts = SocialMediaAccount::latest()->get();

        return response()->json([
            'success' => true,
            'data' => SocialMediaAccountResource::collection($accounts),
        ]);
    }

    public function store(
        StoreSocialMediaAccountRequest $request
    ): JsonResponse {
        $account = SocialMediaAccount::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social media content created successfully.',
            'data' => new SocialMediaAccountResource($account),
        ], 201);
    }

    public function show(
        SocialMediaAccount $socialMediaAccount
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data' => new SocialMediaAccountResource($socialMediaAccount),
        ]);
    }

    public function update(
        UpdateSocialMediaAccountRequest $request,
        SocialMediaAccount $socialMediaAccount
    ): JsonResponse {
        $socialMediaAccount->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social media content updated successfully.',
            'data' => new SocialMediaAccountResource(
                $socialMediaAccount->fresh()
            ),
        ]);
    }

    public function destroy(
        SocialMediaAccount $socialMediaAccount
    ): JsonResponse {
        $socialMediaAccount->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social media content deleted successfully.',
        ]);
    }
}
