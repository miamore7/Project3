<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user dan login
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function show_profile_page_is_accessible()
    {
        $response = $this->get(route('profile.show'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.show');
        $response->assertViewHas('user');
    }

    /** @test */
    public function edit_profile_page_is_accessible()
    {
        $response = $this->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user');
    }

    /** @test */
    public function update_profile_without_password()
    {
        $response = $this->put(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('profile.show'));

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
    public function update_profile_with_password()
    {
        $response = $this->put(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect(route('profile.show'));

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $this->assertTrue(
            password_verify('newpassword', $this->user->fresh()->password)
        );
    }
}
