<?php

namespace App\Http\Controllers\Api\V1\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::orderBy('group')
            ->orderBy('key')
            ->get();

        return response()->json([
            'success' => true,
            'data' => SettingResource::collection($settings),
        ]);
    }

    public function show(Setting $setting): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new SettingResource($setting),
        ]);
    }

    public function update(
        UpdateSettingRequest $request,
        Setting $setting
    ): JsonResponse {
        $setting->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully.',
            'data' => new SettingResource($setting),
        ]);
    }
}
