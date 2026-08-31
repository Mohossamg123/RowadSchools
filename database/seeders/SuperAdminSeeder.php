<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::query()->where('slug', 'super-admin')->first();

        if (!$superAdminRole) {
            return;
        }

        // القيم الإفتراضية للإدمن الأولي — تم نقلها داخل السيدر
        // بدلًا من .env لتجنب الخلط أثناء النشر والتطوير.
        $email = 'admin@rowad.com';
        $password = 'Rowad@10003';

        // updateOrCreate بدل firstOrCreate: كده تشغيل السيدر بيضمن دايمًا
        // إن الإيميل/الباسورد دول يشتغلوا، حتى لو المستخدم كان موجود
        // بباسورد مختلف/ضايع من قبل (زي الحالة اللي كنا فيها).
        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'phone' => '0500000000',
                'password' => Hash::make($password),
                'status' => 'active',
                'language' => 'ar',
            ]
        );

        $this->command?->info("✅ سوبر أدمن جاهز — الإيميل: {$email}");

        $user->roles()->syncWithoutDetaching([$superAdminRole->id]);
    }
}
