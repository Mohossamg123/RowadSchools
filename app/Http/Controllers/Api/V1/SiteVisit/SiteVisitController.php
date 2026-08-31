<?php

namespace App\Http\Controllers\Api\V1\SiteVisit;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteVisit\StoreSiteVisitRequest;
use App\Http\Resources\SiteVisitResource;
use App\Models\SiteVisit;
use Illuminate\Http\JsonResponse;

class SiteVisitController extends Controller
{
    public function store(StoreSiteVisitRequest $request): JsonResponse
    {
        $visit = SiteVisit::create();

        return response()->json([
            'success' => true,
            'message' => 'Visit recorded successfully.',
            'data' => new SiteVisitResource($visit),
        ], 201);
    }
}
