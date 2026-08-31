<?php

namespace App\Http\Controllers\Api\V1\HomepageFeature;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomepageFeature\StoreHomepageFeatureRequest;
use App\Http\Requests\HomepageFeature\UpdateHomepageFeatureRequest;
use App\Http\Resources\HomepageFeatureResource;
use App\Models\HomepageFeature;
use Illuminate\Http\JsonResponse;

class HomepageFeatureController extends Controller
{
    public function index(): JsonResponse
    {
        $features = HomepageFeature::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => HomepageFeatureResource::collection($features),
        ]);
    }

    public function store(StoreHomepageFeatureRequest $request): JsonResponse
    {
        $feature = HomepageFeature::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Feature created successfully.',
            'data' => new HomepageFeatureResource($feature),
        ], 201);
    }

    public function show(HomepageFeature $homepageFeature): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new HomepageFeatureResource($homepageFeature),
        ]);
    }

    public function update(
        UpdateHomepageFeatureRequest $request,
        HomepageFeature $homepageFeature
    ): JsonResponse {
        $homepageFeature->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Feature updated successfully.',
            'data' => new HomepageFeatureResource($homepageFeature),
        ]);
    }

    public function destroy(HomepageFeature $homepageFeature): JsonResponse
    {
        $homepageFeature->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feature deleted successfully.',
        ]);
    }
}
