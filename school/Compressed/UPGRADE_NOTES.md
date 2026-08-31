# تعليمات التشغيل بعد التحديث

## 1) الأمان — خطوات لازم تتعمل فورًا

1. **باسورد الداتابيز الحقيقي كان متسرّب** في ملف `.env` القديم (اللي اترفع
   في الزيب الأول). شيّله دلوقتي من لوحة تحكم الاستضافة وغيّره فورًا.
2. الملف `.env` الحقيقي **متضمنش** في الزيب ده عمدًا — فيه بس `.env.example`
   نظيف. اعمل نسخة `.env` جديدة من `.env.example` واملأ فيها القيم
   الحقيقية (`DB_PASSWORD` الجديد، `APP_KEY` جديد بـ `php artisan key:generate`، إلخ).
3. حدد `SUPER_ADMIN_PASSWORD` في `.env` **قبل** أي `php artisan migrate:fresh --seed`
   على السيرفر الحقيقي — السيدر بقى مرفوض يستخدم باسورد افتراضي معروف
   (`password123`) زي الأول؛ لو سبته فاضي هيولّد باسورد عشوائي قوي
   ويطبعه في الكونسول مرة واحدة بس، وعليك تاخده فورًا وتغيّره.
4. اضبط `CORS_ALLOWED_ORIGINS` في `.env` بدومينات الموقع والداشبورد
   الحقيقية (مفصولة بفاصلة)، بدل ما يفضل مفتوح لأي دومين.
5. اضبط `APP_ENV=production` و `LOG_LEVEL=error` على السيرفر اللايف
   (موجودين كده صح في `.env.example` الجديد).

## 2) تشغيل الميجريشنز والسيدرز

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env   # ثم املأ القيم الحقيقية
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link   # لو مش متعمل قبل كده
```

الميجريشنز الجديدة اللي هتتضاف:
- `hero_slides`
- `special_offer_pages`
- `special_offer_page_images`

السيدرز الجديدة/المعدّلة:
- `PermissionSeeder` — أضاف صلاحيتين: `hero-slides.manage`, `special-offer-pages.manage`
- `SuperAdminSeeder` — بقى يقرأ الباسورد من `SUPER_ADMIN_PASSWORD` بدل ما يفترض واحد ثابت
- `RowadStaticContentSeeder` — بقى يزرع كمان:
  - صور الهيرو الحقيقية (hero-1/2/3.webp) في جدول `hero_slides`
  - صفحة "عن المدرسة" وأقسامها (رؤيتنا/رسالتنا/قيمنا/من نحن/نبذة تفصيلية) في `pages` + `page_sections`

## 3) اللي اتصلح في الباك اند (لارافيل)

| المشكلة | الحل |
|---|---|
| مفيش Hero Slides في الباك اند خالص | Model + Migration + Controller + Requests + Resource + Routes كاملين |
| Special Offer Pages كنترولرز موجودة بس مش متوصلة بجداول ولا routes | Migrations جديدة + admin routes + public route بالسلاج |
| `noindex`/`nofollow` مش متحقق منهم في الـ Requests | اتضافوا لقواعد الـ validation في Store/Update |
| Admin يقدر يـ 404 وهو بيفتح special offer page غير مفعّلة | `show()` بقى يفرّق بين زائر عادي وأدمن مسجل دخول |
| `.env` حقيقي فيه باسورد داتابيز production متسرّب | اتشال من الزيب، `.env.example` نظيف بدله |
| باسورد سوبر أدمن افتراضي `password123` | السيدر بقى يرفض يشتغل من غير `SUPER_ADMIN_PASSWORD` أو يولّد باسورد عشوائي قوي |
| رفع SVG مسموح بيه (XSS) | اتشال `svg` من `mimes:` في `MediaController` |
| `language` مش في `User::$fillable` | اتضاف — كان بيتجاهل بصمت |
| إيميل تسجيل الطالب بيبعت sync (`Mail::send`) | بقى `Mail::queue()` + الـ Mailable بقى `ShouldQueue` |
| ملفات `.save`/`.save.1` زيادة | اتشالوا |
| مفيش rate limit مخصص على `/auth/login` | اتضاف `throttle:5,1` |
| مفيش `config/cors.php` | اتضاف — يقرأ الدومينات المسموحة من `CORS_ALLOWED_ORIGINS` |

## 4) اللي اتصلح في الداشبورد (rowad-admin)

- **`src/services/heroSlides.ts`**: كان شغال بالكامل على `localStorage`
  (مش متصل بأي API). بقى يتكلم مع `/admin/hero-slides` الحقيقي (رفع
  multipart، تحديث، حذف، ترتيب).
- **`src/pages/HeroEditor.tsx`**: كان بيدّي وهم إن ممكن تعدّل العنوان/الوصف/
  الأزرار بتاعة الهيرو، لكن دول ثابتين في كود الموقع مش قابلين للتعديل.
  بقت الصفحة صور بس (زي صفحة المعرض)، مطابقة لواقع الباك اند فعليًا.
- **`src/types/index.ts`**: `HeroSlide` type بسّطناه لصورة + ترتيب + حالة
  بس (شيلنا `eyebrow`/`title_line1`/`title_line2`/`button1`/`button2`).
- **`src/services/fees.ts`**: كان بيكلم `/admin/special-offers` و
  `/admin/special-offer-images` (مسارات مش موجودة أصلاً)، وبيتوقع عمود
  `is_indexed` مش موجود. بقى يتكلم مع `/admin/special-offer-pages` و
  `/admin/special-offer-page-images` الحقيقيين، ويربط "مفهرسة" بعكس
  `noindex` الراجع فعليًا من الباك اند.
- **`src/lib/sitePages.ts`**: `INTERNAL_SITE_PAGES` (قائمة روابط الموقع
  الداخلية) اتنقلت هنا من `services/heroSlides.ts` عشان تفضل متاحة
  لـ `LinkPicker` في كل الصفحات (مش مرتبطة بالهيرو تحديدًا).

## 5) الفرونت إند الرئيسي (rowad-main)

مفيش تعديلات لازمة — `useHeroSlides.ts` و `Hero.tsx` و `api.ts` أصلاً
متوقعين بالظبط شكل الـ API اللي اتبنى دلوقتي (صورة + ترتيب + حالة بس)،
وبيرجعوا تلقائيًا للصور الثابتة (`hero-1/2/3.webp`) لو الطلب فشل.

## 6) حاجات لسه محتاجة قرار منك (مش خطيرة، بس تستحق وقت لاحقًا)

- توحيد كود رفع/حذف الصور المكرر في كل كنترولر (Gallery, SpecialOfferPage,
  Testimonial...) في Trait أو Service واحد، أو تفعيل `MediaController`
  الموجود بالفعل وربطه بدل التكرار.
- تحسين `DashboardController` لاستعلام واحد بدل 10 `count()` منفصلة —
  مش أولوية لحجم مدرسة، بس سهل لو حبيت.
- كاش لـ `hasRole()`/`hasPermission()` في `User` model لو الترافيك زاد.
