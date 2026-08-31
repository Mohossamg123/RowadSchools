<?php

namespace App\Support;

class IconResolver
{
    /**
     * عمود "icon" ممكن يكون:
     *  - مفتاح أيقونة Lucide ثابت (زي "eye"، "graduation-cap") — من غير سلاش،
     *    بيترجع زي ما هو عشان الفرونت يرسمه بمكتبة lucide-react.
     *  - مسار ملف مرفوع (زي "icons/2026/08/xxxx.webp" أو "icons/.../xxxx.svg")
     *    — فيه سلاش، فبنحوله لرابط كامل عبر storage.
     */
    public static function resolve(?string $icon): ?string
    {
        if (!$icon) {
            return $icon;
        }

        if (str_starts_with($icon, 'http://') || str_starts_with($icon, 'https://')) {
            return $icon;
        }

        if (str_contains($icon, '/')) {
            return asset('storage/' . ltrim($icon, '/'));
        }

        return $icon;
    }
}
