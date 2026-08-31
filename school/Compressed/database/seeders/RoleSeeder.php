<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full access to all admin operations', 'status' => true],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'General administrator', 'status' => true],
            ['name' => 'Editor', 'slug' => 'editor', 'description' => 'Content editor', 'status' => true],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(
                ['slug' => $role['slug']],
                [
                    'name' => $role['name'],
                    'description' => $role['description'],
                    'status' => $role['status'],
                ]
            );
        }
    }
}
