<?php

namespace App\Http\Controllers\Api\V1\TuitionFee;

use App\Http\Controllers\Controller;
use App\Http\Requests\TuitionFee\UpdateTuitionFeeSettingRequest;
use App\Models\TuitionFeeSetting;
use Illuminate\Http\JsonResponse;

class TuitionFeeSettingController extends Controller
{
    public function show(): JsonResponse
    {
        $setting = TuitionFeeSetting::first();

        if (!$setting) {
            $setting = TuitionFeeSetting::create([
                'is_enabled' => true,
                'seo_indexable' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_enabled' => $setting->is_enabled,
                'seo_indexable' => $setting->seo_indexable,
            ],
        ]);
    }

    public function update(UpdateTuitionFeeSettingRequest $request): JsonResponse
    {
        $setting = TuitionFeeSetting::first();

        if (!$setting) {
            $setting = TuitionFeeSetting::create([
                'is_enabled' => $request->boolean('is_enabled', true),
                'seo_indexable' => $request->boolean('seo_indexable', false),
            ]);
        } else {
            $setting->update($request->validated());
        }

        return response()->json([
            'success' => true,
            'message' => 'Tuition fee settings updated successfully.',
            'data' => [
                'is_enabled' => $setting->is_enabled,
                'seo_indexable' => $setting->seo_indexable,
            ],
        ]);
    }
}
