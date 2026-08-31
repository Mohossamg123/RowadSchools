<?php

namespace App\Http\Controllers\Api\V1\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function index(): JsonResponse
    {
        $pages = Page::with('sections')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => PageResource::collection($pages),
        ]);
    }

    public function store(StorePageRequest $request): JsonResponse
    {
        $page = Page::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Page created successfully.',
            'data' => new PageResource($page),
        ], 201);
    }

    public function show(Page $page): JsonResponse
    {
        $page->load('sections');

        return response()->json([
            'success' => true,
            'data' => new PageResource($page),
        ]);
    }

    public function update(
        UpdatePageRequest $request,
        Page $page
    ): JsonResponse {
        $page->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Page updated successfully.',
            'data' => new PageResource($page->fresh('sections')),
        ]);
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->delete();

        return response()->json([
            'success' => true,
            'message' => 'Page deleted successfully.',
        ]);
    }
}
