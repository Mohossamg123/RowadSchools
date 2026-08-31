<?php

namespace App\Http\Controllers\Api\V1\FAQ;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Http\Resources\FAQResource;
use App\Models\FAQ;
use Illuminate\Http\JsonResponse;

class FAQController extends Controller
{
    public function index(): JsonResponse
    {
        $faqs = FAQ::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => FAQResource::collection($faqs),
        ]);
    }

    public function store(StoreFAQRequest $request): JsonResponse
    {
        $faq = FAQ::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ created successfully.',
            'data' => new FAQResource($faq),
        ], 201);
    }

    public function show(FAQ $faq): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new FAQResource($faq),
        ]);
    }

    public function update(
        UpdateFAQRequest $request,
        FAQ $faq
    ): JsonResponse {
        $faq->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully.',
            'data' => new FAQResource($faq->fresh()),
        ]);
    }

    public function destroy(FAQ $faq): JsonResponse
    {
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ deleted successfully.',
        ]);
    }
}
