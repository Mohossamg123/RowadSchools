<?php

namespace App\Http\Controllers\Api\V1\FAQ;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQ\StoreFAQRequest;
use App\Http\Requests\FAQ\UpdateFAQRequest;
use App\Http\Resources\FAQResource;
use App\Models\FAQ;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FAQ::with('category')
            ->where('status', true)
            ->orderBy('sort_order');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return response()->json([
            'success' => true,
            'data' => FAQResource::collection($query->get()),
        ]);
    }

    public function store(StoreFAQRequest $request): JsonResponse
    {
        $faq = FAQ::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ created successfully.',
            'data' => new FAQResource($faq->load('category')),
        ], 201);
    }

    public function show(FAQ $faq): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new FAQResource($faq->load('category')),
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
            'data' => new FAQResource($faq->fresh()->load('category')),
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