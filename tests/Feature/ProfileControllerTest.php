<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user dan login
        $this->user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
        ]);
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
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('profile.updated', true);

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
            'password' => 'newsecurepassword',
            'password_confirmation' => 'newsecurepassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('profile.updated', true);

        $user = $this->user->fresh();

        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertTrue(Hash::check('newsecurepassword', $user->password));
    }
}
