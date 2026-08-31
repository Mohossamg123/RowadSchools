<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'school_name', 'value' => 'مدارس رواد النجاح الأهلية', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '0598501515', 'type' => 'string', 'group' => 'contacts'],
            ['key' => 'contact_email', 'value' => null, 'type' => 'string', 'group' => 'contacts'],
            ['key' => 'contact_whatsapp', 'value' => 'https://wa.me/message/R5BYTCGVVHPIC1', 'type' => 'string', 'group' => 'contacts'],
            ['key' => 'address', 'value' => 'حفر الباطن، المملكة العربية السعودية', 'type' => 'string', 'group' => 'general'],
            ['key' => 'maps_url', 'value' => 'https://maps.app.goo.gl/GUvC99UxiVcT1Hbz9', 'type' => 'string', 'group' => 'general'],
            ['key' => 'working_hours', 'value' => 'الأحد - الخميس، 7 ص إلى 3 م', 'type' => 'string', 'group' => 'general'],
            ['key' => 'default_meta_description', 'value' => 'مدارس رواد النجاح الأهلية — بيئة تعليمية تثق بها.', 'type' => 'string', 'group' => 'seo'],

            // Homepage hero text & buttons (edited from "النص والأزرار" في لوحة التحكم)
            ['key' => 'hero_eyebrow', 'value' => 'مدارس رواد النجاح الأهلية', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_title_line1', 'value' => 'بيئة تعليمية', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_title_line2', 'value' => 'تثق بها', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_description', 'value' => 'نصنع لأبنائنا تجربة تعليمية متكاملة تجمع بين القيم الأصيلة والمناهج الحديثة في بيئة آمنة تُلهم الموهبة وتَبني الشخصية.', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_button1_label', 'value' => 'تعرف علينا', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_button1_url', 'value' => '/about', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_button2_label', 'value' => 'سجل الآن', 'type' => 'string', 'group' => 'hero'],
            ['key' => 'hero_button2_url', 'value' => '/admissions', 'type' => 'string', 'group' => 'hero'],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                ]
            );
        }
    }
}
