<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);

        $dashboard = $this->get(route('admin.dashboard'));

        $dashboard->assertOk()->assertSee('Dashboard Buku Tamu');
    }

    public function test_non_admin_cannot_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $response = $this->from(route('login'))->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
