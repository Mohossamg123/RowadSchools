<?php

namespace App\Http\Controllers\Api\V1\AchievementStat;

use App\Http\Controllers\Controller;
use App\Http\Requests\AchievementStat\StoreAchievementStatRequest;
use App\Http\Requests\AchievementStat\UpdateAchievementStatRequest;
use App\Http\Resources\AchievementStatResource;
use App\Models\AchievementStat;
use Illuminate\Http\JsonResponse;

class AchievementStatController extends Controller
{
    public function index(): JsonResponse
    {
        $stats = AchievementStat::query()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => AchievementStatResource::collection($stats),
        ]);
    }

    public function store(StoreAchievementStatRequest $request): JsonResponse
    {
        $stat = AchievementStat::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Achievement stat created successfully.',
            'data' => new AchievementStatResource($stat->fresh()),
        ], 201);
    }

    public function show(AchievementStat $achievementStat): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new AchievementStatResource($achievementStat),
        ]);
    }

    public function update(
        UpdateAchievementStatRequest $request,
        AchievementStat $achievementStat
    ): JsonResponse {
        $achievementStat->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Achievement stat updated successfully.',
            'data' => new AchievementStatResource($achievementStat->fresh()),
        ]);
    }

    public function destroy(AchievementStat $achievementStat): JsonResponse
    {
        $achievementStat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Achievement stat deleted successfully.',
        ]);
    }
}
