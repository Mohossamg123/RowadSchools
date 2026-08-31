<?php

namespace App\Http\Controllers\Api\V1\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;

class AnnouncementController extends Controller
{
    public function index(): JsonResponse
    {
        $announcements = Announcement::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => AnnouncementResource::collection($announcements),
        ]);
    }

    public function store(StoreAnnouncementRequest $request): JsonResponse
    {
        $announcement = Announcement::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Announcement created successfully.',
            'data' => new AnnouncementResource($announcement),
        ], 201);
    }

    public function show(Announcement $announcement): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new AnnouncementResource($announcement),
        ]);
    }

    public function update(
        UpdateAnnouncementRequest $request,
        Announcement $announcement
    ): JsonResponse {
        $announcement->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Announcement updated successfully.',
            'data' => new AnnouncementResource($announcement),
        ]);
    }

    public function destroy(Announcement $announcement): JsonResponse
    {
        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Announcement deleted successfully.',
        ]);
    }
}
