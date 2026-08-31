<?php

namespace App\Http\Controllers\Api\V1\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageSection\StorePageSectionRequest;
use App\Http\Requests\PageSection\UpdatePageSectionRequest;
use App\Http\Resources\PageSectionResource;
use App\Models\PageSection;
use Illuminate\Http\JsonResponse;

class PageSectionController extends Controller
{
    public function index(): JsonResponse
    {
        $sections = PageSection::with('page')
            ->orderBy('sort_order')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => PageSectionResource::collection($sections),
        ]);
    }

    public function store(StorePageSectionRequest $request): JsonResponse
    {
        $section = PageSection::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Page section created successfully.',
            'data' => new PageSectionResource($section),
        ], 201);
    }

    public function show(PageSection $pageSection): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PageSectionResource($pageSection),
        ]);
    }

    public function update(
        UpdatePageSectionRequest $request,
        PageSection $pageSection
    ): JsonResponse {
        $pageSection->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Page section updated successfully.',
            'data' => new PageSectionResource($pageSection),
        ]);
    }

    public function destroy(PageSection $pageSection): JsonResponse
    {
        $pageSection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Page section deleted successfully.',
        ]);
    }
}
