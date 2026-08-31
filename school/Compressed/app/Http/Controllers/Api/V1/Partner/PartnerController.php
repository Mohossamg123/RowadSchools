<?php

namespace App\Http\Controllers\Api\V1\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;

class PartnerController extends Controller
{
    public function __construct(
        private ImageUploadService $imageUploadService
    ) {}

    public function index(): JsonResponse
    {
        $partners = Partner::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => PartnerResource::collection($partners),
        ]);
    }

    public function store(StorePartnerRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->imageUploadService->upload(
                $request->file('logo'),
                'partners'
            );
        }

        $partner = Partner::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Partner created successfully.',
            'data' => new PartnerResource($partner),
        ], 201);
    }

    public function show(Partner $partner): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PartnerResource($partner),
        ]);
    }

    public function update(
        UpdatePartnerRequest $request,
        Partner $partner
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->imageUploadService->upload(
                $request->file('logo'),
                'partners'
            );
        }

        $partner->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Partner updated successfully.',
            'data' => new PartnerResource($partner->fresh()),
        ]);
    }

    public function destroy(Partner $partner): JsonResponse
    {
        $partner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Partner deleted successfully.',
        ]);
    }
}
