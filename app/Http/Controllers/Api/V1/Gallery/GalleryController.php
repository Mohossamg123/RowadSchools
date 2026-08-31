<?php

namespace App\Http\Controllers\Api\V1\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\StoreGalleryRequest;
use App\Http\Requests\Gallery\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    public function index(): JsonResponse
    {
        $galleries = Gallery::with('images')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => GalleryResource::collection($galleries),
        ]);
    }

    public function store(StoreGalleryRequest $request): JsonResponse
    {
        $gallery = Gallery::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Gallery created successfully.',
            'data' => new GalleryResource($gallery),
        ], 201);
    }

    public function show(Gallery $gallery): JsonResponse
    {
        $gallery->load('images');

        return response()->json([
            'success' => true,
            'data' => new GalleryResource($gallery),
        ]);
    }

    public function update(
        UpdateGalleryRequest $request,
        Gallery $gallery
    ): JsonResponse {
        $gallery->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Gallery updated successfully.',
            'data' => new GalleryResource(
                $gallery->fresh('images')
            ),
        ]);
    }

    public function destroy(Gallery $gallery): JsonResponse
    {
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery deleted successfully.',
        ]);
    }
}
