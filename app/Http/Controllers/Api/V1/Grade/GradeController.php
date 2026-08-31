<?php

namespace App\Http\Controllers\Api\V1\Grade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\StoreGradeRequest;
use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\JsonResponse;

class GradeController extends Controller
{
    public function index(): JsonResponse
    {
        $grades = Grade::with('educationalStage')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => GradeResource::collection($grades),
        ]);
    }

    public function store(StoreGradeRequest $request): JsonResponse
    {
        $grade = Grade::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Grade created successfully.',
            'data' => new GradeResource($grade),
        ], 201);
    }

    public function show(Grade $grade): JsonResponse
    {
        $grade->load([
            'educationalStage',
            'tuitionFees',
        ]);

        return response()->json([
            'success' => true,
            'data' => new GradeResource($grade),
        ]);
    }

    public function update(
        UpdateGradeRequest $request,
        Grade $grade
    ): JsonResponse {
        $grade->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Grade updated successfully.',
            'data' => new GradeResource(
                $grade->fresh(['educationalStage', 'tuitionFees'])
            ),
        ]);
    }

    public function destroy(Grade $grade): JsonResponse
    {
        $grade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Grade deleted successfully.',
        ]);
    }
}
