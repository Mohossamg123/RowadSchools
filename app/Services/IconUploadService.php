<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IconUploadService
{
    /** أقصى أبعاد للأيقونة بعد الضغط — الأيقونات صغيرة بطبعها فمش محتاجين أبعاد كبيرة */
    private const MAX_DIMENSION = 512;

    /** جودة WebP بعد الضغط (0-100) — 82 بيدي حجم صغير من غير فقدان جودة محسوس */
    private const WEBP_QUALITY = 82;

    /**
     * بيرفع أيقونة/صورة (SVG أو PNG/JPEG/WebP/GIF) في storage/app/public/{folder}
     * وبيرجع المسار النسبي (بدون asset()) عشان يتخزن في العمود زي ما هو.
     *
     * - SVG: بتتنضف من أي <script> ثم تتخزن زي ما هي (متجهية، مفيش داعي لضغط).
     * - باقي الصيغ: لو GD متاحة، بتتحول لـ WebP مع تصغير الأبعاد لتقليل الحجم
     *   من غير ما تفقد وضوحها كأيقونة. لو GD مش متاحة، بيتخزن الملف الأصلي.
     */
    public function upload(UploadedFile $file, string $folder = 'icons'): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $dir = trim($folder, '/') . '/' . date('Y/m');

        if ($extension === 'svg' || $file->getMimeType() === 'image/svg+xml') {
            return $this->storeSvg($file, $dir);
        }

        if (extension_loaded('gd')) {
            $stored = $this->storeCompressed($file, $dir);
            if ($stored) {
                return $stored;
            }
        }

        // فولباك: GD مش متاحة أو فشل الضغط — نخزن الملف الأصلي زي ما هو
        return $file->store($dir, 'public');
    }

    private function storeSvg(UploadedFile $file, string $dir): string
    {
        $contents = file_get_contents($file->getRealPath());

        // تنظيف بسيط: مسح أي وسم <script> أو on* event handlers من الـ SVG
        $contents = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $contents ?? '') ?? '';
        $contents = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $contents) ?? '';
        $contents = preg_replace("/\son\w+\s*=\s*'[^']*'/i", '', $contents) ?? '';

        $filename = $dir . '/' . Str::random(32) . '.svg';
        Storage::disk('public')->put($filename, $contents);

        return $filename;
    }

    private function storeCompressed(UploadedFile $file, string $dir): ?string
    {
        $path = $file->getRealPath();
        $mime = $file->getMimeType();

        $image = match ($mime) {
            'image/png' => @imagecreatefrompng($path),
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path),
            'image/webp' => @imagecreatefromwebp($path),
            'image/gif' => @imagecreatefromgif($path),
            default => null,
        };

        if (!$image) {
            return null;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        // نحافظ على الشفافية (مهم للأيقونات PNG بخلفية شفافة)
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        if ($width > self::MAX_DIMENSION || $height > self::MAX_DIMENSION) {
            $ratio = min(self::MAX_DIMENSION / $width, self::MAX_DIMENSION / $height);
            $newWidth = (int) round($width * $ratio);
            $newHeight = (int) round($height * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagepalettetotruecolor($resized);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefill($resized, 0, 0, $transparent);

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        $filename = $dir . '/' . Str::random(32) . '.webp';
        $fullPath = Storage::disk('public')->path($filename);

        // نتأكد إن الفولدر موجود قبل الكتابة المباشرة بالـ GD
        Storage::disk('public')->makeDirectory($dir);

        $ok = function_exists('imagewebp') ? imagewebp($image, $fullPath, self::WEBP_QUALITY) : false;
        imagedestroy($image);

        return $ok ? $filename : null;
    }
}
