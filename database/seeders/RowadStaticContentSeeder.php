<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RowadStaticContentSeeder extends Seeder
{
    protected string $dataPath;

    public function __construct()
    {
        $this->dataPath = __DIR__;
    }

    public function run(): void
    {
        $this->seedOffers();
        $this->seedTestimonials();
        // ⚠️ وسائل الدفع (payment_methods) بقت مسؤولية PaymentMethodSeeder
        // بس — كانت هنا بتعيد زرع نسخة قديمة (فيها "google_pay" غلط بدل
        // "mastercard") وبتوفر status كل seed جديد، فبتمسح أي تفعيل/تعطيل
        // حقيقي عمله الأدمن من الداشبورد. اتشالت لتفادي التعارض.
        [$stageIdBySlug] = $this->seedStagesAndGrades();
        $this->seedTuitionFees($stageIdBySlug);
        $this->seedSocialLinks();
        $this->seedLinksPage();
        // ⚠️ مزايا الرئيسية (homepage_features) بقت مسؤولية
        // HomepageFeatureSeeder بس — لنفس سبب وسائل الدفع فوق.
        $this->seedSettings();
        $this->seedSpecialOffers();
        $this->seedHeroSlides();
        $this->seedPages();

        $this->command?->info('✅ تم زرع المحتوى الثابت من البيانات الجاهزة في المشروع.');
    }

    protected function json(string $file): array
    {
        $path = "{$this->dataPath}/{$file}";
        if (!file_exists($path)) {
            $this->command?->warn("⚠️  ملف مفقود: {$path}");
            return [];
        }

        return json_decode((string) file_get_contents($path), true) ?? [];
    }

    protected function seedOffers(): void
    {
        foreach ($this->json('offers.json') as $row) {
            DB::table('offers')->updateOrInsert(
                ['title' => $row['title']],
                [
                    'description' => $row['description'] ?? null,
                    'badge_text' => $row['badge_text'] ?? null,
                    'discount' => $row['discount'] ?? null,
                    'image' => $row['image'] ?? null,
                    'button_text' => $row['button_text'] ?? null,
                    'button_url' => $row['button_url'] ?? null,
                    'start_date' => $row['start_date'] ?? null,
                    'end_date' => $row['end_date'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function seedTestimonials(): void
    {
        foreach ($this->json('testimonials.json') as $row) {
            DB::table('testimonials')->updateOrInsert(
                ['name' => $row['name'] ?? $row['author_name'] ?? null, 'content' => $row['content']],
                [
                    'role' => $row['role'] ?? $row['role_label'] ?? null,
                    'rating' => (int) ($row['rating'] ?? 5),
                    'image' => $row['image'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? $row['is_published'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * @deprecated غير مستخدمة — PaymentMethodSeeder هو المصدر الوحيد لجدول
     * payment_methods دلوقتي. اتسابت هنا للمرجعية بس، ما تتنادوش من run().
     */
    protected function seedPaymentMethods(): void
    {
        foreach ($this->json('payment_methods.json') as $row) {
            $slug = $row['slug'] ?? $row['key'] ?? strtolower((string) $row['label']);
            $name = $row['name'] ?? $row['label'] ?? ucfirst((string) $slug);

            DB::table('payment_methods')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'icon' => $row['icon'] ?? null,
                    'description' => $row['description'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? $row['is_enabled'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function seedStagesAndGrades(): array
    {
        $stageIdBySlug = [];

        foreach ($this->json('stages.json') as $row) {
            DB::table('educational_stages')->updateOrInsert(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                    'image' => $row['image'] ?? null,
                    'icon' => $row['icon'] ?? null,
                    'age_from' => $row['age_from'] ?? null,
                    'age_to' => $row['age_to'] ?? null,
                    'features' => isset($row['features']) ? json_encode($row['features'], JSON_UNESCAPED_UNICODE) : null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? $row['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $stageIdBySlug[$row['slug']] = DB::table('educational_stages')
                ->where('slug', $row['slug'])
                ->value('id');
        }

        foreach ($this->json('grades.json') as $row) {
            $stageId = $stageIdBySlug[$row['stage_slug']] ?? null;
            if (!$stageId) {
                continue;
            }

            DB::table('grades')->updateOrInsert(
                ['educational_stage_id' => $stageId, 'slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? $row['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return [$stageIdBySlug];
    }

    protected function seedTuitionFees(array $stageIdBySlug): void
    {
        $feesByTier = collect($this->json('tuition_fees.json'))->keyBy('tier');
        $grades = $this->json('grades.json');

        foreach ($grades as $grade) {
            $fee = $feesByTier->get($grade['tier'] ?? null);
            if (!$fee) {
                continue;
            }

            $gradeId = DB::table('grades')
                ->where('slug', $grade['slug'])
                ->value('id');

            if (!$gradeId) {
                continue;
            }

            DB::table('tuition_fees')->updateOrInsert(
                ['grade_id' => $gradeId, 'academic_year' => $fee['academic_year']],
                [
                    'annual_fee' => (float) ($fee['cash_amount'] ?? 0),
                    'registration_fee' => (float) ($fee['registration_fee'] ?? 0),
                    'installment_amount' => (float) ($fee['installments_amount'] ?? $fee['monthly_amount'] ?? 0),
                    'installment_count' => (int) ($fee['installment_count'] ?? 1),
                    'sibling_discount' => (float) ($fee['sibling_discount'] ?? 0),
                    'notes' => $fee['note'] ?? null,
                    'status' => (bool) ($fee['status'] ?? $fee['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function seedSocialLinks(): void
    {
        foreach ($this->json('social_links.json') as $row) {
            DB::table('social_links')->updateOrInsert(
                ['url' => $row['url']],
                [
                    'title' => $row['label'] ?? $row['title'] ?? 'Link',
                    'icon' => $row['icon'] ?? null,
                    'type' => $row['type'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? $row['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function seedLinksPage(): void
    {
        foreach ($this->json('links_page.json') as $row) {
            DB::table('social_links')->updateOrInsert(
                ['url' => $row['url']],
                [
                    'title' => $row['label'] ?? $row['title'] ?? 'Link',
                    'icon' => $row['icon'] ?? null,
                    'type' => $row['type'] ?? 'linktree',
                    'sort_order' => 100 + ($row['sort_order'] ?? 0),
                    'status' => (bool) ($row['status'] ?? $row['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * @deprecated غير مستخدمة — HomepageFeatureSeeder هو المصدر الوحيد
     * لجدول homepage_features دلوقتي. اتسابت هنا للمرجعية بس.
     */
    protected function seedHomepageFeatures(): void
    {
        foreach ($this->json('homepage_features.json') as $row) {
            DB::table('homepage_features')->updateOrInsert(
                ['title' => $row['title']],
                [
                    'description' => $row['description'] ?? null,
                    'icon' => $row['icon'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? $row['is_active'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function seedSettings(): void
    {
        $rows = $this->json('settings.json');
        if (empty($rows)) {
            return;
        }

        foreach ($rows as $key => $value) {
            // موجود بالفعل؟ متلمسوش القيمة عشان منمسحش تعديل حقيقي عمله
            // الأدمن من صفحة الإعدادات في seed لاحق — نضيف الصف بس لو
            // مفتاح جديد (زي working_hours/maps_url/footer_description
            // اللي كانوا مش موجودين قبل كده).
            if (DB::table('settings')->where('key', $key)->exists()) {
                continue;
            }

            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'type' => 'string',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedSpecialOffers(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('special_offer_pages')) {
            return;
        }

        foreach ($this->json('special_offers.json') as $row) {
            DB::table('special_offer_pages')->updateOrInsert(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'description' => $row['description'] ?? null,
                    'is_active' => (bool) ($row['is_active'] ?? true),
                    'noindex' => !($row['is_indexed'] ?? false),
                    'nofollow' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * الهيرو الرئيسي — بيدير الصور بس. بينسخ الصور الحقيقية اللي كانت
     * ثابتة جوه كود الموقع الخارجي (rowad-main/src/assets/hero-*.webp)
     * من database/seeders/assets/hero لـ storage/app/public/hero،
     * وبيزرع صف hero_slides لكل واحدة، عشان الداشبورد والموقع يبتدوا
     * بمحتوى حقيقي مش placeholder فاضي.
     */
    protected function seedHeroSlides(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('hero_slides')) {
            return;
        }

        $assetsDir = "{$this->dataPath}/assets/hero";

        foreach ($this->json('hero_slides.json') as $row) {
            $sourceFile = "{$assetsDir}/{$row['file']}";

            if (!file_exists($sourceFile)) {
                $this->command?->warn("⚠️  صورة هيرو مفقودة: {$sourceFile}");
                continue;
            }

            $storagePath = 'hero/' . $row['file'];

            if (!Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->put(
                    $storagePath,
                    file_get_contents($sourceFile)
                );
            }

            DB::table('hero_slides')->updateOrInsert(
                ['image' => $storagePath],
                [
                    'sort_order' => $row['sort_order'] ?? 0,
                    'status' => (bool) ($row['status'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * صفحات ثابتة (زي "عن المدرسة") مع أقسامها — عناوين الأقسام لازم
     * تطابق بالظبط اللي الموقع بيدور عليه (usePageContent → findSection)
     * عشان تحل محل الفولباك الثابت جوه الكود.
     */
    protected function seedPages(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('pages')) {
            return;
        }

        foreach ($this->json('pages.json') as $page) {
            DB::table('pages')->updateOrInsert(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'meta_title' => $page['meta_title'] ?? null,
                    'meta_description' => $page['meta_description'] ?? null,
                    'is_published' => (bool) ($page['is_published'] ?? true),
                    'is_indexable' => (bool) ($page['is_indexable'] ?? true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $pageId = DB::table('pages')
                ->where('slug', $page['slug'])
                ->value('id');

            if (!$pageId) {
                continue;
            }

            foreach ($page['sections'] ?? [] as $section) {
                DB::table('page_sections')->updateOrInsert(
                    ['page_id' => $pageId, 'title' => $section['title']],
                    [
                        'subtitle' => $section['subtitle'] ?? null,
                        'content' => $section['content'] ?? null,
                        'image' => $section['image'] ?? null,
                        'sort_order' => $section['sort_order'] ?? 0,
                        'status' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
