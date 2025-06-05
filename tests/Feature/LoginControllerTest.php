<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
/** @test */
public function login_succeeds_with_valid_credentials_and_auth_is_true()
{
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
    ]);

    $response = $this->post('/login', [
        'email' => 'user@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('user.dashboard'));
    $this->assertAuthenticatedAs($user);
    $this->assertTrue(auth()->check());
}

/** @test */
public function login_fails_with_empty_input_and_auth_is_false()
{
    $response = $this->from('/login')->post('/login', [
        'email' => '',
        'password' => '',
    ]);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors(['email', 'password']);
    $this->assertFalse(auth()->check());
    $this->assertGuest();
}

}
