<?php

namespace Database\Seeders;

use App\Models\EducationalStage;
use Illuminate\Database\Seeder;

class EducationalStageSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'مرحلة الروضة',
                'slug' => 'kg',
                'description' => 'روضة مع النقل — بنين وبنات',
                'age_from' => 3,
                'age_to' => 5,
                'features' => [
                    'بيئة تعلم باللعب والأنشطة التفاعلية',
                    'تنمية المهارات الحركية واللغوية المبكرة',
                    'رعاية تربوية ونفسية متكاملة للطفل',
                ],
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'المرحلة الابتدائية',
                'slug' => 'primary',
                'description' => 'أول إلى سادس — بنين وبنات',
                'age_from' => 6,
                'age_to' => 11,
                'features' => [
                    'تأسيس قوي في القرآن الكريم واللغة العربية',
                    'برامج إثرائية للعلوم والرياضيات والحاسب',
                    'أنشطة رياضية وفنية واجتماعية متنوعة',
                ],
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'المرحلة المتوسطة',
                'slug' => 'middle',
                'description' => 'أول إلى ثالث — بنات فقط',
                'age_from' => 12,
                'age_to' => 14,
                'features' => [
                    'منهجية تفكير نقدي وحل المشكلات',
                    'مختبرات علمية وتطبيقات تقنية حديثة',
                    'أنشطة قيادية وبناء الشخصية المستقلة',
                ],
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'المرحلة الثانوية',
                'slug' => 'secondary',
                'description' => 'أول إلى ثالث — بنات فقط',
                'age_from' => 15,
                'age_to' => 17,
                'features' => [
                    'برامج تدريب مكثفة للقدرات والتحصيلي',
                    'إرشاد أكاديمي وجامعي متخصص',
                    'شراكات وتعليم رقمي متقدم',
                ],
                'sort_order' => 4,
                'status' => true,
            ],
        ];

        foreach ($data as $stage) {
            EducationalStage::query()->updateOrCreate(
                ['slug' => $stage['slug']],
                [
                    'name' => $stage['name'],
                    'description' => $stage['description'],
                    'age_from' => $stage['age_from'],
                    'age_to' => $stage['age_to'],
                    'features' => $stage['features'],
                    'sort_order' => $stage['sort_order'],
                    'status' => $stage['status'],
                ]
            );
        }
    }
}
