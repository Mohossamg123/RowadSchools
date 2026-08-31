# إصلاحات هذه الجولة (v7 باك اند / v8 موقع رئيسي)

## 1) سبب اختفاء/كسر صور الهيرو (NS_BINDING_ABORTED / OpaqueResponseBlocking)

المشكلة الحقيقية: الباك اند بيبني رابط الصورة بـ `asset('storage/...')`، والرابط
ده بيتحدد حسب قيمة `APP_URL` في ملف `.env` **على السيرفر الحي فعليًا** (الملف ده
مش موجود جوه الزيب لأنه بيفضل على السيرفر ومتسجلش في السورس). لو `APP_URL`
متظبط غلط (متطابق مع دومين الموقع العام `rowad-alnajah.pyramedx.com` بدل دومين
الباك اند `rowad-school.pyramedx.com`)، كل روابط الصور بترجع لدومين مفيهوش
Laravel أصلاً. الدومين ده عنده `.htaccess` بيحوّل أي مسار مش موجود
(`/storage/hero/hero-1.webp` جواه) إلى `index.html` (SPA fallback) — يعني
المتصفح بيطلب صورة ويرجعله HTML، فبيحصل Opaque Response Blocking.

**خطوة لازم تتأكد منها على السيرفر:**
```
# جوه .env بتاع الباك اند (rowad-school.pyramedx.com)
APP_URL=https://rowad-school.pyramedx.com
```
وبعدها:
```
php artisan config:clear
php artisan optimize:clear
```

**إصلاح إضافي في كود الموقع الرئيسي (main) عشان ميتكررش المشكلة حتى لو
`APP_URL` اتغلط تاني مستقبلاً:** أضفت دالة `resolveAssetUrl()` في
`src/lib/api.ts` بتاخد أي رابط صورة راجع من الباك اند وتجبره يتبني على نفس
أصل (origin) الـ `VITE_API_BASE_URL` المضبوط في بيئة البناء، مش على أي دومين
تاني. اتطبقت على: صور الهيرو (`useHeroSlides.ts`)، صور المراحل التعليمية
(`useStagesContent.ts`)، وصور العروض (`Offers.tsx`).

كمان صلّحت الـ fallback الافتراضي لـ `API_BASE_URL` نفسه (كان بيرجع لدومين
الموقع العام بالغلط لو `VITE_API_BASE_URL` مش موجودة وقت البناء — دلوقتي
بيرجع لدومين الباك اند الصح).

**تأكد إن ملف `main/.env` (أو `.env.production`) موجود فعليًا وقت `npm run
build`** بالقيمة:
```
VITE_API_BASE_URL=https://rowad-school.pyramedx.com/api/v1
```
ملف زيه ده مش موجود في السورس (متعمول له `.gitignore` عادة) — فلو مبنيتش
الموقع بيه، بيرجع للـ fallback المكتوب جوه الكود.

## 2) مميزات الصفحة الرئيسية (Homepage Features) مش ظاهرة

السبب: `GET /api/v1/home` كان بيرجّع المفتاح `features`، لكن الفرونت
(`Features.tsx`) بيقرا `data.homepage_features`. اتصلح في
`HomeController::index()` — المفتاح بقى `homepage_features` مطابق تمامًا.

لوحة الإدارة (`admin/src/pages/HomepageFeatures.tsx` +
`services/homepageFeatures.ts`) كانت أصلاً متصلة صح بـ
`/admin/homepage-features` (CRUD كامل) — مفيش تعديل مطلوب هناك، المشكلة كانت
بس في شكل رد `/home` العام.

**خطوة بعد الرفع:** مفيش migration جديدة، بس امسح الكاش:
```
php artisan config:clear
php artisan route:clear
```

## 3) حاجات لسه مش مربوطة (خارج نطاق هذه الجولة، للعلم بس)

- **صفحة معرض الصور العامة (`/gallery` في main)** لسه شاشة "قريباً" ثابتة —
  مش بتسحب من `GET /api/v1/gallery` رغم إن الباك اند والـ Model كاملين.
  محتاجة بناء واجهة عرض فعلية لو عايز أكملها في جولة تانية.
- **SpecialOfferPage** (صفحة/معرض عرض خاص) موجودة بالكامل في الباك اند
  (Model + Controller + Resource) بس مش متربطة بأي Route في الموقع العام.
  قوللي لو عايزها تظهر كصفحة عامة وهعملها.
