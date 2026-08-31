<?php

namespace App\Http\Controllers\Api\V1\Upload;

use App\Http\Controllers\Controller;
use App\Services\IconUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(
        private readonly IconUploadService $uploader
    ) {
    }

    /**
     * رفع أيقونة/صورة عامة (SVG, PNG, JPEG, WebP, GIF) — بتترجع المسار
     * النسبي (لتخزينه في عمود icon/image) والرابط الكامل الجاهز للعرض.
     * بيتضغط تلقائيًا (تصغير الأبعاد + تحويل لـ WebP) لو مش SVG.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:5120', // 5MB
                'mimes:svg,png,jpg,jpeg,webp,gif',
            ],
        ]);

        $path = $this->uploader->upload($request->file('file'), 'icons');

        return response()->json([
            'success' => true,
            'message' => 'تم رفع الأيقونة بنجاح.',
            'data' => [
                'path' => $path,
                'url' => asset('storage/' . $path),
            ],
        ], 201);
    }
}
