<?php

namespace App\Http\Controllers\Api\V1\SpecialOfferPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialOfferPage\StoreSpecialOfferPageImageRequest;
use App\Http\Resources\SpecialOfferPageImageResource;
use App\Models\SpecialOfferPageImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SpecialOfferPageImageController extends Controller
{
    public function store(
        StoreSpecialOfferPageImageRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $data['image'] = $request
            ->file('image')
            ->store('special-offers', 'public');

        $image = SpecialOfferPageImage::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'data' => new SpecialOfferPageImageResource($image),
        ], 201);
    }

    public function destroy(
        SpecialOfferPageImage $specialOfferPageImage
    ): JsonResponse {
        if ($specialOfferPageImage->image) {
            Storage::disk('public')->delete(
                $specialOfferPageImage->image
            );
        }

        $specialOfferPageImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ]);
    }
}
