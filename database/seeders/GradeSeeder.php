<?php

namespace Database\Seeders;

use App\Models\EducationalStage;
use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $stageMap = [
            'kg' => EducationalStage::query()->where('slug', 'kg')->first(),
            'primary' => EducationalStage::query()->where('slug', 'primary')->first(),
            'middle' => EducationalStage::query()->where('slug', 'middle')->first(),
            'secondary' => EducationalStage::query()->where('slug', 'secondary')->first(),
        ];

        $data = [
            ['stage_slug' => 'kg', 'slug' => 'kg1', 'name' => 'روضة الأولى', 'sort_order' => 1],
            ['stage_slug' => 'kg', 'slug' => 'kg2', 'name' => 'روضة الثانية', 'sort_order' => 2],
            ['stage_slug' => 'kg', 'slug' => 'kg3', 'name' => 'روضة الثالثة', 'sort_order' => 3],
            ['stage_slug' => 'primary', 'slug' => 'p1', 'name' => 'الصف الأول ابتدائي', 'sort_order' => 1],
            ['stage_slug' => 'primary', 'slug' => 'p2', 'name' => 'الصف الثاني ابتدائي', 'sort_order' => 2],
            ['stage_slug' => 'primary', 'slug' => 'p3', 'name' => 'الصف الثالث ابتدائي', 'sort_order' => 3],
            ['stage_slug' => 'primary', 'slug' => 'p4', 'name' => 'الصف الرابع ابتدائي', 'sort_order' => 4],
            ['stage_slug' => 'primary', 'slug' => 'p5', 'name' => 'الصف الخامس ابتدائي', 'sort_order' => 5],
            ['stage_slug' => 'primary', 'slug' => 'p6', 'name' => 'الصف السادس ابتدائي', 'sort_order' => 6],
            ['stage_slug' => 'middle', 'slug' => 'm1', 'name' => 'الصف الأول متوسط', 'sort_order' => 1],
            ['stage_slug' => 'middle', 'slug' => 'm2', 'name' => 'الصف الثاني متوسط', 'sort_order' => 2],
            ['stage_slug' => 'middle', 'slug' => 'm3', 'name' => 'الصف الثالث متوسط', 'sort_order' => 3],
            ['stage_slug' => 'secondary', 'slug' => 's1', 'name' => 'الصف الأول ثانوي', 'sort_order' => 1],
            ['stage_slug' => 'secondary', 'slug' => 's2', 'name' => 'الصف الثاني ثانوي', 'sort_order' => 2],
            ['stage_slug' => 'secondary', 'slug' => 's3', 'name' => 'الصف الثالث ثانوي', 'sort_order' => 3],
        ];

        foreach ($data as $grade) {
            $stage = $stageMap[$grade['stage_slug']] ?? null;
            if (!$stage) {
                continue;
            }

            Grade::query()->updateOrCreate(
                ['educational_stage_id' => $stage->id, 'slug' => $grade['slug']],
                [
                    'name' => $grade['name'],
                    'sort_order' => $grade['sort_order'],
                    'status' => true,
                ]
            );
        }
    }
}
