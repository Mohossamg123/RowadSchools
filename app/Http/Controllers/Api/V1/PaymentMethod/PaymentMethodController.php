<?php

namespace App\Http\Controllers\Api\V1\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    public function index(): JsonResponse
    {
        $methods = PaymentMethod::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => PaymentMethodResource::collection($methods),
        ]);
    }

    public function store(
        StorePaymentMethodRequest $request
    ): JsonResponse {
        $method = PaymentMethod::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Payment method created successfully.',
            'data' => new PaymentMethodResource($method),
        ], 201);
    }

    public function show(PaymentMethod $paymentMethod): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PaymentMethodResource($paymentMethod),
        ]);
    }

    public function update(
        UpdatePaymentMethodRequest $request,
        PaymentMethod $paymentMethod
    ): JsonResponse {
        $paymentMethod->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated successfully.',
            'data' => new PaymentMethodResource($paymentMethod),
        ]);
    }

    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully.',
        ]);
    }
}
