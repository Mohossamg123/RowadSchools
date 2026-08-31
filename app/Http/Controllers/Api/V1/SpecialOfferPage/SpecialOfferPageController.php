<?php

namespace App\Http\Controllers\Api\V1\SpecialOfferPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialOfferPage\StoreSpecialOfferPageRequest;
use App\Http\Requests\SpecialOfferPage\UpdateSpecialOfferPageRequest;
use App\Http\Resources\SpecialOfferPageResource;
use App\Models\SpecialOfferPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialOfferPageController extends Controller
{
    public function index(): JsonResponse
    {
        $pages = SpecialOfferPage::with('images')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => SpecialOfferPageResource::collection($pages),
        ]);
    }

    public function store(
        StoreSpecialOfferPageRequest $request
    ): JsonResponse {
        $page = SpecialOfferPage::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Special offer page created successfully.',
            'data' => new SpecialOfferPageResource(
                $page->load('images')
            ),
        ], 201);
    }

    public function show(
        Request $request,
        SpecialOfferPage $specialOfferPage
    ): JsonResponse {
        // This action is shared by the public slug route and the admin
        // resource route. Inactive pages are hidden from anonymous
        // visitors, but an authenticated admin still needs to see them
        // (e.g. to review/activate a draft page).
        if (!$specialOfferPage->is_active && !$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found.',
            ], 404);
        }

        $specialOfferPage->load('images');

        return response()->json([
            'success' => true,
            'data' => new SpecialOfferPageResource(
                $specialOfferPage
            ),
        ]);
    }

    public function update(
        UpdateSpecialOfferPageRequest $request,
        SpecialOfferPage $specialOfferPage
    ): JsonResponse {
        $specialOfferPage->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Special offer page updated successfully.',
            'data' => new SpecialOfferPageResource(
                $specialOfferPage->fresh('images')
            ),
        ]);
    }

    public function destroy(
        SpecialOfferPage $specialOfferPage
    ): JsonResponse {
        $specialOfferPage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Special offer page deleted successfully.',
        ]);
    }
}
