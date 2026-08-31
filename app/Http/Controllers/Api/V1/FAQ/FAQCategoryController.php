<?php

namespace App\Http\Controllers\Api\V1\FAQ;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQCategory\StoreFAQCategoryRequest;
use App\Http\Requests\FAQCategory\UpdateFAQCategoryRequest;
use App\Http\Resources\FAQCategoryResource;
use App\Models\FAQCategory;
use Illuminate\Http\JsonResponse;

class FAQCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = FAQCategory::with('faqs')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => FAQCategoryResource::collection($categories),
        ]);
    }

    public function store(StoreFAQCategoryRequest $request): JsonResponse
    {
        $category = FAQCategory::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ category created successfully.',
            'data' => new FAQCategoryResource($category),
        ], 201);
    }

    public function show(FAQCategory $faqCategory): JsonResponse
    {
        $faqCategory->load('faqs');

        return response()->json([
            'success' => true,
            'data' => new FAQCategoryResource($faqCategory),
        ]);
    }

    public function update(
        UpdateFAQCategoryRequest $request,
        FAQCategory $faqCategory
    ): JsonResponse {
        $faqCategory->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ category updated successfully.',
            'data' => new FAQCategoryResource($faqCategory),
        ]);
    }

    public function destroy(FAQCategory $faqCategory): JsonResponse
    {
        $faqCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ category deleted successfully.',
        ]);
    }
}