<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Public Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\Home\HomeController;
use App\Http\Controllers\Api\V1\Page\PageController;
use App\Http\Controllers\Api\V1\EducationalStage\EducationalStageController;
use App\Http\Controllers\Api\V1\Grade\GradeController;
use App\Http\Controllers\Api\V1\TuitionFee\TuitionFeeController;
use App\Http\Controllers\Api\V1\FAQ\FAQController;
use App\Http\Controllers\Api\V1\Offer\OfferController;
use App\Http\Controllers\Api\V1\Announcement\AnnouncementController;
use App\Http\Controllers\Api\V1\Testimonial\TestimonialController;
use App\Http\Controllers\Api\V1\Gallery\GalleryController;
use App\Http\Controllers\Api\V1\Partner\PartnerController;
use App\Http\Controllers\Api\V1\HeroSlide\HeroSlideController;
use App\Http\Controllers\Api\V1\AchievementStat\AchievementStatController;
use App\Http\Controllers\Api\V1\SpecialOfferPage\SpecialOfferPageController;
use App\Http\Controllers\Api\V1\SocialLink\SocialLinkController;
use App\Http\Controllers\Api\V1\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\Api\V1\Setting\SettingController;
use App\Http\Controllers\Api\V1\StudentRegistration\StudentRegistrationController;
use App\Http\Controllers\Api\V1\SocialMedia\SocialMediaController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\Admin\DashboardController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Admin Content Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\Page\PageSectionController;
use App\Http\Controllers\Api\V1\HomepageFeature\HomepageFeatureController;
use App\Http\Controllers\Api\V1\Gallery\GalleryImageController;
use App\Http\Controllers\Api\V1\SpecialOfferPage\SpecialOfferPageImageController;

/*
|--------------------------------------------------------------------------
| Public Links Page
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\PublicLinks\PublicLinksController;


/*
|--------------------------------------------------------------------------
| API V1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC ROUTES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Social Media 
    |--------------------------------------------------------------------------
    */

    Route::get('/social-media/posts', [
        SocialMediaController::class,
        'posts',
    ]);
    
    Route::get('/social-media', [
    SocialMediaController::class,
    'index',
]);


    /*
    |--------------------------------------------------------------------------
    | Homepage
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [
        HomeController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    Route::get('/pages', [
        PageController::class,
        'index',
    ]);

    Route::get('/pages/{page}', [
        PageController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Educational Stages
    |--------------------------------------------------------------------------
    */

    Route::get('/stages', [
        EducationalStageController::class,
        'index',
    ]);

    Route::get('/stages/{educationalStage}', [
        EducationalStageController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Grades
    |--------------------------------------------------------------------------
    */

    Route::get('/grades', [
        GradeController::class,
        'index',
    ]);

    Route::get('/grades/{grade}', [
        GradeController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Tuition Fees
    |--------------------------------------------------------------------------
    */

    Route::get('/partners', [
        PartnerController::class,
        'index',
    ]);

    Route::get('/partners/{partner}', [
        PartnerController::class,
        'show',
    ]);

    Route::get('/faqs', [
        FAQController::class,
        'index',
    ]);

    Route::get('/faqs/{faq}', [
        FAQController::class,
        'show',
    ]);


    Route::get('/tuition-fees', [
        TuitionFeeController::class,
        'index',
    ]);

    Route::get('/tuition-fees/{tuitionFee}', [
        TuitionFeeController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Offers
    |--------------------------------------------------------------------------
    */

    Route::get('/offers', [
        OfferController::class,
        'index',
    ]);

    Route::get('/offers/{offer}', [
        OfferController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Announcements
    |--------------------------------------------------------------------------
    */

    Route::get('/announcements', [
        AnnouncementController::class,
        'index',
    ]);

    Route::get('/announcements/{announcement}', [
        AnnouncementController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Testimonials
    |--------------------------------------------------------------------------
    */

    Route::get('/testimonials', [
        TestimonialController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Gallery
    |--------------------------------------------------------------------------
    */

    Route::get('/gallery', [
        GalleryController::class,
        'index',
    ]);

    Route::get('/gallery/{gallery}', [
        GalleryController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Hero Slides
    |--------------------------------------------------------------------------
    */

    Route::get('/hero-slides', [
        HeroSlideController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Special Offer Pages
    |--------------------------------------------------------------------------
    */

    Route::get('/special-offer-pages/{specialOfferPage:slug}', [
        SpecialOfferPageController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Social Links
    |--------------------------------------------------------------------------
    */

    Route::get('/social-links', [
        SocialLinkController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    */

    Route::get('/payment-methods', [
        PaymentMethodController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Public Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [
        SettingController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Public Achievement Stats
    |--------------------------------------------------------------------------
    */

    Route::get('/achievements', [
        AchievementStatController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Public Linktree-style Page
    |--------------------------------------------------------------------------
    */

    Route::get('/links', [
        PublicLinksController::class,
        'index',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::post('/auth/login', [
        AuthController::class,
        'login',
    ])->middleware('throttle:5,1');


    /*
    |--------------------------------------------------------------------------
    | Student Registration
    |--------------------------------------------------------------------------
    |
    | Public.
    | Parent/student can submit registration without login.
    |
    */

    Route::post('/student-registrations', [
        StudentRegistrationController::class,
        'store',
    ]);


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    |
    | Every route below requires:
    |
    | 1. Sanctum authentication
    | 2. Admin role
    |
    */

    Route::middleware([
        'auth:sanctum',
        'admin',
    ])
    ->prefix('admin')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        Route::get('/me', [
            AuthController::class,
            'me',
        ]);

        Route::post('/logout', [
            AuthController::class,
            'logout',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generic Icon / Image Upload (achievements, homepage features, page
        | sections icons...) — أي أدمن مسجّل دخول يقدر يستخدمه
        |--------------------------------------------------------------------------
        */
        Route::post('/uploads/image', [
    \App\Http\Controllers\Api\V1\Upload\ImageUploadController::class,
    'store',
]);

        /*
        |--------------------------------------------------------------------------
        | Social Media Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:social-media.manage')
            ->group(function () {

                Route::apiResource(
                    'social-media',
                    SocialMediaController::class
                )->parameters([
                    'social-media' => 'socialMediaAccount',
                ]);

                Route::post(
                    '/social-media/{socialMediaAccount}/sync',
                    [
                        SocialMediaController::class,
                        'sync',
                    ]
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Users / Admin Accounts
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:users.manage')
            ->group(function () {

                Route::apiResource(
                    'users',
                    UserController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:roles.manage')
            ->group(function () {

                Route::apiResource(
                    'roles',
                    RoleController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:roles.manage')
            ->group(function () {

                Route::apiResource(
                    'permissions',
                    PermissionController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Pages Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:pages.manage')
            ->group(function () {

                Route::apiResource(
                    'pages',
                    PageController::class
                )->parameters([
                    'pages' => 'page',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Page Sections Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:page-sections.manage')
            ->group(function () {

                Route::apiResource(
                    'page-sections',
                    PageSectionController::class
                )->parameters([
                    'page-sections' => 'pageSection',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Educational Stages Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:stages.manage')
            ->group(function () {

                Route::apiResource(
                    'stages',
                    EducationalStageController::class
                )->parameters([
                    'stages' => 'educationalStage',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Grades Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:grades.manage')
            ->group(function () {

                Route::apiResource(
                    'grades',
                    GradeController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Tuition Fees Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:faqs.manage')
            ->group(function () {

                Route::apiResource('faqs', FAQController::class);

            });


        Route::middleware('permission:tuition-fees.manage')
            ->group(function () {

                Route::apiResource(
                    'tuition-fees',
                    TuitionFeeController::class
                )->parameters([
                    'tuition-fees' => 'tuitionFee',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Homepage Features Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:homepage-features.manage')
            ->group(function () {

                Route::apiResource(
                    'homepage-features',
                    HomepageFeatureController::class
                )->parameters([
                    'homepage-features' => 'homepageFeature',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Hero Slides Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:hero-slides.manage')
            ->group(function () {

                Route::apiResource(
                    'hero-slides',
                    HeroSlideController::class
                )->parameters([
                    'hero-slides' => 'heroSlide',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Special Offer Pages Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:special-offer-pages.manage')
            ->group(function () {

                Route::apiResource(
                    'special-offer-pages',
                    SpecialOfferPageController::class
                )->parameters([
                    'special-offer-pages' => 'specialOfferPage',
                ]);

                Route::post('/special-offer-page-images', [
                    SpecialOfferPageImageController::class,
                    'store',
                ]);

                Route::delete('/special-offer-page-images/{specialOfferPageImage}', [
                    SpecialOfferPageImageController::class,
                    'destroy',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Offers Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:offers.manage')
            ->group(function () {

                Route::apiResource(
                    'offers',
                    OfferController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Announcements Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:announcements.manage')
            ->group(function () {

                Route::apiResource(
                    'announcements',
                    AnnouncementController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Testimonials Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:testimonials.manage')
            ->group(function () {

                Route::apiResource(
                    'testimonials',
                    TestimonialController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Student Registrations Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:registrations.manage')
            ->group(function () {

                Route::apiResource(
                    'registrations',
                    StudentRegistrationController::class
                )->parameters([
                    'registrations' => 'studentRegistration',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Partners Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:partners.manage')
            ->group(function () {

                Route::apiResource(
                    'partners',
                    PartnerController::class
                )->parameters([
                    'partners' => 'partner',
                ]);

            });

        /*
        |--------------------------------------------------------------------------
        | Galleries Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:galleries.manage')
            ->group(function () {

                Route::apiResource(
                    'galleries',
                    GalleryController::class
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Gallery Images Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:gallery-images.manage')
            ->group(function () {

                Route::apiResource(
                    'gallery-images',
                    GalleryImageController::class
                )->parameters([
                    'gallery-images' => 'galleryImage',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Social Links Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:social-links.manage')
            ->group(function () {

                Route::apiResource(
                    'social-links',
                    SocialLinkController::class
                )->parameters([
                    'social-links' => 'socialLink',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Payment Methods Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:payment-methods.manage')
            ->group(function () {

                Route::apiResource(
                    'payment-methods',
                    PaymentMethodController::class
                )->parameters([
                    'payment-methods' => 'paymentMethod',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Settings Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:settings.manage')
            ->group(function () {

                Route::get('/settings', [
                    SettingController::class,
                    'index',
                ]);

                Route::get('/settings/{setting}', [
                    SettingController::class,
                    'show',
                ]);

                Route::put('/settings/{setting}', [
                    SettingController::class,
                    'update',
                ]);

            });


        /*
        |--------------------------------------------------------------------------
        | Achievement Stats Management
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:achievements.manage')
            ->group(function () {

                Route::apiResource(
                    'achievements',
                    AchievementStatController::class
                )->parameters([
                    'achievements' => 'achievementStat',
                ]);

            });

    });

});
