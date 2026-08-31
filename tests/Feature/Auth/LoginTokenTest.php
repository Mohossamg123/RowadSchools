<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_users_can_login_without_invalidating_each_others_tokens(): void
    {
        $firstUser = User::create([
            'name' => 'Admin User One',
            'email' => 'admin1@example.com',
            'password' => Hash::make('secret123'),
            'status' => 'active',
        ]);

        $secondUser = User::create([
            'name' => 'Admin User Two',
            'email' => 'admin2@example.com',
            'password' => Hash::make('secret456'),
            'status' => 'active',
        ]);

        $firstLogin = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin1@example.com',
            'password' => 'secret123',
        ]);

        $firstLogin->assertStatus(200);

        $secondLogin = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin2@example.com',
            'password' => 'secret456',
        ]);

        $secondLogin->assertStatus(200);

        $this->assertDatabaseCount('personal_access_tokens', 2);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $firstUser->id,
            'tokenable_type' => User::class,
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $secondUser->id,
            'tokenable_type' => User::class,
        ]);
    }
}
