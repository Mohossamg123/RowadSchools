<?php

namespace Database\Seeders;

use App\Models\AchievementStat;
use Illuminate\Database\Seeder;

class AchievementStatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'icon' => 'calendar-days',
                'value' => '+15',
                'label' => 'عامًا من التميز',
                'note' => 'خبرة في تقديم تعليم جودة',
                'sort_order' => 1,
            ],
            [
                'icon' => 'award',
                'value' => '98%',
                'label' => 'نسبة نجاح الطلاب',
                'note' => 'نتائج متميزة في الاختبارات',
                'sort_order' => 2,
            ],
            [
                'icon' => 'users',
                'value' => '+120',
                'label' => 'معلم ومعلمة',
                'note' => 'كادر تعليمي مؤهل ذو خبرة عالية',
                'sort_order' => 3,
            ],
            [
                'icon' => 'graduation-cap',
                'value' => '+2500',
                'label' => 'طالب وطالبة',
                'note' => 'ثقة آلاف الأسر في مدارسنا',
                'sort_order' => 4,
            ],
        ];

        foreach ($data as $row) {
            AchievementStat::updateOrCreate(
                ['label' => $row['label']],
                [...$row, 'status' => true]
            );
        }
    }
}