<?php

namespace Database\Seeders;

use App\Models\HomepageFeature;
use Illuminate\Database\Seeder;

class HomepageFeatureSeeder extends Seeder
{
    public function run(): void
    {
        // المزايا الحقيقية المعروضة في قسم "لماذا رواد النجاح؟" بالرئيسية
        // (من 4 لحد 6 بطاقات حسب التصميم — دي الافتراضية الأربعة الحالية).
        $features = [
            ['title' => 'بيئة آمنة ومحفزة', 'description' => 'مرافق حديثة تضمن الراحة والأمان', 'icon' => 'shield', 'sort_order' => 1],
            ['title' => 'تعليم متميز', 'description' => 'مناهج تواكب المعايير الدولية', 'icon' => 'book-open', 'sort_order' => 2],
            ['title' => 'كادر تعليمي مؤهل', 'description' => 'معلمون بخبرة وكفاءة عالية', 'icon' => 'users', 'sort_order' => 3],
            ['title' => 'تطوير شامل', 'description' => 'ننمي المهارات الأكاديمية والقيادية', 'icon' => 'trending-up', 'sort_order' => 4],
        ];

        $titles = array_column($features, 'title');

        foreach ($features as $feature) {
            $existing = HomepageFeature::query()->where('title', $feature['title'])->first();

            if ($existing) {
                // موجود بالفعل — منحدّثش الوصف/الأيقونة عشان منمسحش أي
                // تعديل حقيقي عمله الأدمن من الداشبورد في seed لاحق.
                continue;
            }

            HomepageFeature::query()->create([...$feature, 'status' => true]);
        }

        // شيل أي مزايا قديمة (زي "قسم العلوم"/"قسم الرياضيات" من نسخة
        // تجريبية سابقة) مش من ضمن المحتوى الحقيقي المطلوب نشره.
        HomepageFeature::query()->whereNotIn('title', $titles)->delete();
    }
}
