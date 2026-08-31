<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Apple Pay', 'slug' => 'apple_pay', 'icon' => 'apple-pay', 'description' => 'الدفع عبر Apple Pay', 'sort_order' => 1, 'status' => true],
            ['name' => 'مدى', 'slug' => 'mada', 'icon' => 'mada', 'description' => 'الدفع عبر مدى', 'sort_order' => 2, 'status' => true],
            ['name' => 'Visa', 'slug' => 'visa', 'icon' => 'visa', 'description' => 'بطاقة فيزا', 'sort_order' => 3, 'status' => true],
            ['name' => 'Mastercard', 'slug' => 'mastercard', 'icon' => 'mastercard', 'description' => 'بطاقة ماستر كارد', 'sort_order' => 4, 'status' => true],
            ['name' => 'تحويل بنكي', 'slug' => 'bank_transfer', 'icon' => 'bank', 'description' => 'تحويل بنكي', 'sort_order' => 5, 'status' => true],
            ['name' => 'كاش', 'slug' => 'cash', 'icon' => 'cash', 'description' => 'الدفع نقدًا', 'sort_order' => 6, 'status' => true],
            ['name' => 'تمارا', 'slug' => 'tamara', 'icon' => 'tamara', 'description' => 'الدفع عبر تمارا', 'sort_order' => 7, 'status' => true],
            ['name' => 'جيل باي', 'slug' => 'jeel_pay', 'icon' => 'jeel-pay', 'description' => 'حلول تمويلية تعليمية عبر جيل باي', 'sort_order' => 8, 'status' => true],
        ];

        foreach ($methods as $method) {
            $existing = PaymentMethod::query()->where('slug', $method['slug'])->first();

            if ($existing) {
                // موجود بالفعل — منحدّثش status عشان منمسحش اختيار الأدمن
                // الحقيقي (زي تفعيل "كاش" بس وتعطيل الباقي) في كل seed جديد.
                $existing->update([
                    'name' => $method['name'],
                    'icon' => $method['icon'],
                    'description' => $method['description'],
                    'sort_order' => $method['sort_order'],
                ]);
                continue;
            }

            PaymentMethod::query()->create($method);
        }

        // تنظيف: نسخة قديمة من الفرونت كانت بتربط زرار "Mastercard" بمفتاح
        // "google_pay" غلط، وده خلّى حد يضيف صف يدوي بسلاج google_pay في
        // الداشبورد عشان الزرار يشتغل — دلوقتي اتصلح في الكود ليقرأ
        // "mastercard" صح، فأي صف بسلاج google_pay بقى نسخة مكررة زايدة.
        PaymentMethod::query()->where('slug', 'google_pay')->delete();
    }
}
