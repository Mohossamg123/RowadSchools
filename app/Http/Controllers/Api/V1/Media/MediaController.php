<?php

namespace App\Http\Controllers\Api\V1\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'folder' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9_\-\/]+$/',
            ],
        ]);

        $folder = $request->input(
            'folder',
            'uploads'
        );

        $path = $request
            ->file('file')
            ->store($folder, 'public');

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully.',

            'data' => [
                'path' => $path,
                'url' => asset(
                    'storage/' . $path
                ),
            ],
        ], 201);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'path' => [
                'required',
                'string',
            ],
        ]);

        $path = $request->path;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully.',
        ]);
    }
}
