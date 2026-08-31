<?php

namespace App\Http\Controllers\Api\V1\AnnouncementBar;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementBar\StoreAnnouncementBarRequest;
use App\Http\Requests\AnnouncementBar\UpdateAnnouncementBarRequest;
use App\Http\Resources\AnnouncementBarResource;
use App\Models\AnnouncementBar;
use Illuminate\Http\JsonResponse;

class AnnouncementBarController extends Controller
{
    public function index(): JsonResponse
    {
        $items = AnnouncementBar::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => AnnouncementBarResource::collection($items),
        ]);
    }

    public function store(StoreAnnouncementBarRequest $request): JsonResponse
    {
        $item = AnnouncementBar::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Announcement bar created successfully.',
            'data' => new AnnouncementBarResource($item),
        ], 201);
    }

    public function show(AnnouncementBar $announcementBar): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new AnnouncementBarResource($announcementBar),
        ]);
    }

    public function update(
        UpdateAnnouncementBarRequest $request,
        AnnouncementBar $announcementBar
    ): JsonResponse {
        $announcementBar->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Announcement bar updated successfully.',
            'data' => new AnnouncementBarResource($announcementBar),
        ]);
    }

    public function destroy(AnnouncementBar $announcementBar): JsonResponse
    {
        $announcementBar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Announcement bar deleted successfully.',
        ]);
    }
}
