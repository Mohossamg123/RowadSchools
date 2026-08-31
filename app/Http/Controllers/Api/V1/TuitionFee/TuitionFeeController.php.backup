<?php

namespace App\Http\Controllers\Api\V1\TuitionFee;

use App\Http\Controllers\Controller;
use App\Http\Requests\TuitionFee\StoreTuitionFeeRequest;
use App\Http\Requests\TuitionFee\UpdateTuitionFeeRequest;
use App\Http\Resources\TuitionFeeResource;
use App\Models\TuitionFee;
use Illuminate\Http\JsonResponse;

class TuitionFeeController extends Controller
{
    public function index(): JsonResponse
    {
        $fees = TuitionFee::with([
            'grade.educationalStage'
        ])
        ->where('status', true)
        ->orderBy('academic_year')
        ->get();

        return response()->json([
            'success' => true,
            'data' => TuitionFeeResource::collection($fees),
        ]);
    }

    public function store(StoreTuitionFeeRequest $request): JsonResponse
    {
        $fee = TuitionFee::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tuition fee created successfully.',
            'data' => new TuitionFeeResource(
                $fee->load('grade.educationalStage')
            ),
        ], 201);
    }

    public function show(TuitionFee $tuitionFee): JsonResponse
    {
        $tuitionFee->load('grade.educationalStage');

        return response()->json([
            'success' => true,
            'data' => new TuitionFeeResource($tuitionFee),
        ]);
    }

    public function update(
        UpdateTuitionFeeRequest $request,
        TuitionFee $tuitionFee
    ): JsonResponse {
        $tuitionFee->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tuition fee updated successfully.',
            'data' => new TuitionFeeResource(
                $tuitionFee->fresh('grade.educationalStage')
            ),
        ]);
    }

    public function destroy(TuitionFee $tuitionFee): JsonResponse
    {
        $tuitionFee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tuition fee deleted successfully.',
        ]);
    }
}
