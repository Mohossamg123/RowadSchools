<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * الهيرو الرئيسي بيدير الصور بس — العنوان/الوصف/الأزرار ثابتين في كود
 * الموقع مش قابلين للتعديل من هنا (راجع src/hooks/useHeroSlides.ts في
 * rowad-main). الـ image بيتخزن كـ path نسبي جوه storage/app/public/hero.
 */
class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
