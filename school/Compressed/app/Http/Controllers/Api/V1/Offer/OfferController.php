<?php

namespace App\Http\Controllers\Api\V1\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;

class OfferController extends Controller
{
    public function index(): JsonResponse
    {
        $offers = Offer::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => OfferResource::collection($offers),
        ]);
    }

    public function store(StoreOfferRequest $request): JsonResponse
    {
        $offer = Offer::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Offer created successfully.',
            'data' => new OfferResource($offer),
        ], 201);
    }

    public function show(Offer $offer): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new OfferResource($offer),
        ]);
    }

    public function update(
        UpdateOfferRequest $request,
        Offer $offer
    ): JsonResponse {
        $offer->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Offer updated successfully.',
            'data' => new OfferResource($offer),
        ]);
    }

    public function destroy(Offer $offer): JsonResponse
    {
        $offer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Offer deleted successfully.',
        ]);
    }
}
