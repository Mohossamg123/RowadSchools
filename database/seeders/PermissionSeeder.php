<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'description' => 'Manage admin users'],
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'description' => 'Manage roles and permissions'],
            ['name' => 'Manage Pages', 'slug' => 'pages.manage', 'description' => 'Manage website pages'],
            ['name' => 'Manage Page Sections', 'slug' => 'page-sections.manage', 'description' => 'Manage page sections'],
            ['name' => 'Manage Stages', 'slug' => 'stages.manage', 'description' => 'Manage educational stages'],
            ['name' => 'Manage Grades', 'slug' => 'grades.manage', 'description' => 'Manage grades'],
            ['name' => 'Manage Tuition Fees', 'slug' => 'tuition-fees.manage', 'description' => 'Manage tuition fee records'],
            ['name' => 'Manage FAQs', 'slug' => 'faqs.manage', 'description' => 'Manage frequently asked questions'],
            ['name' => 'Manage Homepage Features', 'slug' => 'homepage-features.manage', 'description' => 'Manage homepage features'],
            ['name' => 'Manage Hero Slides', 'slug' => 'hero-slides.manage', 'description' => 'Manage homepage hero slider images'],
            ['name' => 'Manage Special Offer Pages', 'slug' => 'special-offer-pages.manage', 'description' => 'Manage special offer landing pages'],
            ['name' => 'Manage Offers', 'slug' => 'offers.manage', 'description' => 'Manage offers'],
            ['name' => 'Manage Announcements', 'slug' => 'announcements.manage', 'description' => 'Manage announcements'],
            ['name' => 'Manage Testimonials', 'slug' => 'testimonials.manage', 'description' => 'Manage testimonials'],
            ['name' => 'Manage Registrations', 'slug' => 'registrations.manage', 'description' => 'Manage student registrations'],
            ['name' => 'Manage Galleries', 'slug' => 'galleries.manage', 'description' => 'Manage galleries'],
            ['name' => 'Manage Gallery Images', 'slug' => 'gallery-images.manage', 'description' => 'Manage gallery images'],
            ['name' => 'Manage Partners', 'slug' => 'partners.manage', 'description' => 'Manage partners and companies'],
            ['name' => 'Manage Social Links', 'slug' => 'social-links.manage', 'description' => 'Manage social links'],
            ['name' => 'Manage Payment Methods', 'slug' => 'payment-methods.manage', 'description' => 'Manage payment methods'],
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'description' => 'Manage site settings'],
            ['name' => 'Manage Achievements', 'slug' => 'achievements.manage', 'description' => 'Manage homepage achievement statistics'],
            ['name' => 'Manage Social Media', 'slug' => 'social-media.manage', 'description' => 'Manage social media feeds and accounts'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                ]
            );
        }
    }
}
