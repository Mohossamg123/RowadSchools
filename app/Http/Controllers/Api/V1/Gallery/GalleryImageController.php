<?php

namespace App\Http\Controllers\Api\V1\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryImage\StoreGalleryImageRequest;
use App\Http\Requests\GalleryImage\UpdateGalleryImageRequest;
use App\Http\Resources\GalleryImageResource;
use App\Models\GalleryImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index(): JsonResponse
    {
        $images = GalleryImage::with('gallery')
            ->orderBy('sort_order')
            ->paginate(30);

        return response()->json([
            'success' => true,
            'data' => GalleryImageResource::collection($images),
        ]);
    }

    public function store(
        StoreGalleryImageRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $data['image'] = $request
            ->file('image')
            ->store('gallery', 'public');

        $image = GalleryImage::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image uploaded successfully.',
            'data' => new GalleryImageResource($image),
        ], 201);
    }

    public function show(GalleryImage $galleryImage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new GalleryImageResource($galleryImage),
        ]);
    }

    public function update(
        UpdateGalleryImageRequest $request,
        GalleryImage $galleryImage
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($galleryImage->image) {
                Storage::disk('public')->delete(
                    $galleryImage->image
                );
            }

            $data['image'] = $request
                ->file('image')
                ->store('gallery', 'public');
        }

        $galleryImage->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image updated successfully.',
            'data' => new GalleryImageResource($galleryImage),
        ]);
    }

    public function destroy(GalleryImage $galleryImage): JsonResponse
    {
        if ($galleryImage->image) {
            Storage::disk('public')->delete(
                $galleryImage->image
            );
        }

        $galleryImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully.',
        ]);
    }
}
