<?php

namespace App\Http\Controllers\Api\V1\SocialMedia;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialMedia\StoreSocialMediaAccountRequest;
use App\Http\Requests\SocialMedia\UpdateSocialMediaAccountRequest;
use App\Http\Resources\SocialMediaAccountResource;
use App\Http\Resources\SocialMediaPostResource;
use App\Models\SocialMediaAccount;
use App\Models\SocialMediaPost;
use Illuminate\Http\JsonResponse;
use App\Jobs\SyncSocialMediaPosts;

class SocialMediaController extends Controller
{
    public function index(): JsonResponse
    {
        $accounts = SocialMediaAccount::with([
            'posts' => function ($query) {
                $query
                    ->where('status', true)
                    ->latest('published_at')
                    ->limit(10);
            },
        ])
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'data' => SocialMediaAccountResource::collection(
                $accounts
            ),
        ]);
    }

    public function store(
        StoreSocialMediaAccountRequest $request
    ): JsonResponse {
        $account = SocialMediaAccount::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,

            'message' =>
                'Social media account created successfully.',

            'data' =>
                new SocialMediaAccountResource($account),
        ], 201);
    }

    public function show(
        SocialMediaAccount $socialMediaAccount
    ): JsonResponse {
        $socialMediaAccount->load([
            'posts' => function ($query) {
                $query
                    ->where('status', true)
                    ->latest('published_at');
            },
        ]);

        return response()->json([
            'success' => true,

            'data' =>
                new SocialMediaAccountResource(
                    $socialMediaAccount
                ),
        ]);
    }

    public function update(
        UpdateSocialMediaAccountRequest $request,
        SocialMediaAccount $socialMediaAccount
    ): JsonResponse {
        $socialMediaAccount->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,

            'message' =>
                'Social media account updated successfully.',

            'data' =>
                new SocialMediaAccountResource(
                    $socialMediaAccount->fresh()
                ),
        ]);
    }

    public function destroy(
        SocialMediaAccount $socialMediaAccount
    ): JsonResponse {
        $socialMediaAccount->posts()->delete();

        $socialMediaAccount->delete();

        return response()->json([
            'success' => true,

            'message' =>
                'Social media account deleted successfully.',
        ]);
    }

    public function sync(
    SocialMediaAccount $socialMediaAccount
): JsonResponse {
    SyncSocialMediaPosts::dispatch(
        $socialMediaAccount->id
    );

    return response()->json([
        'success' => true,

        'message' =>
            'Social media synchronization has been queued.',

        'data' => [
            'account_id' => $socialMediaAccount->id,
        ],
    ], 202);
}

    public function posts(): JsonResponse
    {
        $posts = SocialMediaPost::with('account')
            ->where('status', true)
            ->latest('published_at')
            ->paginate(20);

        return response()->json([
            'success' => true,

            'data' =>
                SocialMediaPostResource::collection($posts),
        ]);
    }
}
