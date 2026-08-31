<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    private const MAX_DIMENSION = 1920;

    private const WEBP_QUALITY = 88;

    public function upload(UploadedFile $file, string $folder = 'hero'): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        $dir = trim($folder, '/') . '/' . date('Y/m');

        if ($extension === 'svg' || $file->getMimeType() === 'image/svg+xml') {
            return $this->storeSvg($file, $dir);
        }

        if (extension_loaded('gd') && function_exists('imagewebp')) {
            $stored = $this->storeCompressed($file, $dir);

            if ($stored) {
                return $stored;
            }
        }

        return $file->store($dir, 'public');
    }

    private function storeSvg(UploadedFile $file, string $dir): string
    {
        $contents = file_get_contents($file->getRealPath());

        $contents = preg_replace(
            '/<script\b[^>]*>(.*?)<\/script>/is',
            '',
            $contents ?? ''
        ) ?? '';

        $contents = preg_replace(
            '/\son\w+\s*=\s*"[^"]*"/i',
            '',
            $contents
        ) ?? '';

        $contents = preg_replace(
            "/\son\w+\s*=\s*'[^']*'/i",
            '',
            $contents
        ) ?? '';

        $filename = $dir . '/' . Str::random(32) . '.svg';

        Storage::disk('public')->put($filename, $contents);

        return $filename;
    }

    private function storeCompressed(
        UploadedFile $file,
        string $dir
    ): ?string {
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

        /*
         * مهم:
         * بعض ملفات PNG تكون Palette/Indexed Color.
         * WebP لا يقبل هذا النوع مباشرة،
         * لذلك نحول الصورة إلى True Color.
         */
        if (!imageistruecolor($image)) {
            $width = imagesx($image);
            $height = imagesy($image);

            $trueColorImage = imagecreatetruecolor(
                $width,
                $height
            );

            imagealphablending($trueColorImage, false);
            imagesavealpha($trueColorImage, true);

            $transparent = imagecolorallocatealpha(
                $trueColorImage,
                0,
                0,
                0,
                127
            );

            imagefill(
                $trueColorImage,
                0,
                0,
                $transparent
            );

            imagecopy(
                $trueColorImage,
                $image,
                0,
                0,
                0,
                0,
                $width,
                $height
            );

            imagedestroy($image);

            $image = $trueColorImage;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        /*
         * تصغير الصور الضخمة مع الحفاظ على النسبة.
         */
        if (
            $width > self::MAX_DIMENSION ||
            $height > self::MAX_DIMENSION
        ) {
            $ratio = min(
                self::MAX_DIMENSION / $width,
                self::MAX_DIMENSION / $height
            );

            $newWidth = (int) round($width * $ratio);
            $newHeight = (int) round($height * $ratio);

            $resized = imagecreatetruecolor(
                $newWidth,
                $newHeight
            );

            /*
             * الحفاظ على الشفافية.
             */
            imagealphablending($resized, false);
            imagesavealpha($resized, true);

            $transparent = imagecolorallocatealpha(
                $resized,
                0,
                0,
                0,
                127
            );

            imagefill(
                $resized,
                0,
                0,
                $transparent
            );

            imagecopyresampled(
                $resized,
                $image,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );

            imagedestroy($image);

            $image = $resized;
        }

        $filename = $dir . '/' . Str::random(32) . '.webp';

        Storage::disk('public')->makeDirectory($dir);

        $fullPath = Storage::disk('public')->path($filename);

        $success = imagewebp(
            $image,
            $fullPath,
            self::WEBP_QUALITY
        );

        imagedestroy($image);

        return $success ? $filename : null;
    }
}
