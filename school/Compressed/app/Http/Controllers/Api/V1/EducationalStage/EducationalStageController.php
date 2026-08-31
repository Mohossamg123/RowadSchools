<?php

namespace App\Http\Controllers\Api\V1\EducationalStage;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationalStage\StoreEducationalStageRequest;
use App\Http\Requests\EducationalStage\UpdateEducationalStageRequest;
use App\Http\Resources\EducationalStageResource;
use App\Models\EducationalStage;
use Illuminate\Http\JsonResponse;

class EducationalStageController extends Controller
{
    public function index(): JsonResponse
    {
        $stages = EducationalStage::with('grades')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => EducationalStageResource::collection($stages),
        ]);
    }

    public function store(StoreEducationalStageRequest $request): JsonResponse
    {
        $stage = EducationalStage::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Educational stage created successfully.',
            'data' => new EducationalStageResource($stage),
        ], 201);
    }

    public function show(EducationalStage $educationalStage): JsonResponse
    {
        $educationalStage->load('grades');

        return response()->json([
            'success' => true,
            'data' => new EducationalStageResource($educationalStage),
        ]);
    }

    public function update(
        UpdateEducationalStageRequest $request,
        EducationalStage $educationalStage
    ): JsonResponse {
        $educationalStage->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Educational stage updated successfully.',
            'data' => new EducationalStageResource(
                $educationalStage->fresh('grades')
            ),
        ]);
    }

    public function destroy(EducationalStage $educationalStage): JsonResponse
    {
        $educationalStage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Educational stage deleted successfully.',
        ]);
    }
}
