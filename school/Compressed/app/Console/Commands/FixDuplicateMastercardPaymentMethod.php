<?php

namespace App\Console\Commands;

use App\Models\PaymentMethod;
use Illuminate\Console\Command;

/**
 * أمر تنظيف لمرة واحدة — بيشيل صف "Mastercard" المكرر بسلاج google_pay
 * اللي كان اتضاف يدوي (أو بسيدر قديم) عشان يعالج باج في الفرونت كان
 * بيربط زرار Mastercard بمفتاح غلط. الفرونت اتصلح دلوقتي يقرأ
 * "mastercard" مباشرة، فالصف القديم بقى نسخة زايدة بس.
 *
 * التشغيل: php artisan payment-methods:fix-duplicate-mastercard
 */
class FixDuplicateMastercardPaymentMethod extends Command
{
    protected $signature = 'payment-methods:fix-duplicate-mastercard';

    protected $description = 'يشيل صف payment_methods المكرر بسلاج google_pay (باج Mastercard القديم)';

    public function handle(): int
    {
        $duplicate = PaymentMethod::query()->where('slug', 'google_pay')->first();

        if (!$duplicate) {
            $this->info('مفيش صف بسلاج google_pay — مفيش حاجة نعملها.');
            return self::SUCCESS;
        }

        $this->info("لاقيت صف مكرر: #{$duplicate->id} - {$duplicate->name} (google_pay) — هيتشال دلوقتي.");
        $duplicate->delete();
        $this->info('✅ اتشال. تأكد إن صف "mastercard" الأصلي لسه موجود ومفعّل زي ما انت عاوزه من الداشبورد.');

        return self::SUCCESS;
    }
}
