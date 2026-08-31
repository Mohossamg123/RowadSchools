<?php

namespace App\Http\Controllers\Api\V1\AnnouncementBar;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementBar\UpdateAnnouncementBarSettingRequest;
use App\Models\AnnouncementBarSetting;
use Illuminate\Http\JsonResponse;

class AnnouncementBarSettingController extends Controller
{
    public function show(): JsonResponse
    {
        $setting = AnnouncementBarSetting::first();

        if (!$setting) {
            $setting = AnnouncementBarSetting::create([
                'is_enabled' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_enabled' => $setting->is_enabled,
            ],
        ]);
    }

    public function update(UpdateAnnouncementBarSettingRequest $request): JsonResponse
    {
        $setting = AnnouncementBarSetting::first();

        if (!$setting) {
            $setting = AnnouncementBarSetting::create([
                'is_enabled' => $request->boolean('is_enabled'),
            ]);
        } else {
            $setting->update([
                'is_enabled' => $request->boolean('is_enabled'),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Announcement bar setting updated successfully.',
            'data' => [
                'is_enabled' => $setting->is_enabled,
            ],
        ]);
    }
}
