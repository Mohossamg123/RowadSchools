<?php

namespace App\Http\Controllers\Api\V1\Upload;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function __construct(
        private readonly ImageUploadService $uploader
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:svg,png,jpg,jpeg,webp,gif',
            ],
        ]);

        $path = $this->uploader->upload(
            $request->file('file'),
            'page-content'
        );

        return response()->json([
            'success' => true,
            'message' => 'تم رفع الصورة بنجاح.',
            'data' => [
                'path' => $path,
                'url' => asset('storage/' . $path),
            ],
        ], 201);
    }
}
