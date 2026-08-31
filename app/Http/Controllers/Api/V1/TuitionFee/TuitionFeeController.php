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
        $data = $request->validated();

        if (isset($data['fees'])) {
            $fees = $data['fees'];

            if (array_key_exists('total', $fees)) {
                $data['annual_fee'] = $fees['total'];
            }

            if (array_key_exists('cash', $fees)) {
                $data['cash_amount'] = $fees['cash'];
            }

            if (array_key_exists('registration', $fees)) {
                $data['registration_fee'] = $fees['registration'];
            }

            if (isset($fees['installment'])) {
                if (array_key_exists('amount', $fees['installment'])) {
                    $data['installment_amount'] = $fees['installment']['amount'];
                }

                if (array_key_exists('count', $fees['installment'])) {
                    $data['installment_count'] = $fees['installment']['count'];
                }
            }

            if (array_key_exists('first_term', $fees)) {
                $data['first_term_amount'] = $fees['first_term'];
            }

            if (array_key_exists('second_term', $fees)) {
                $data['second_term_amount'] = $fees['second_term'];
            }

            unset($data['fees']);
        }

        $tuitionFee->update($data);

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
