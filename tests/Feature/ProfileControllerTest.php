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
 /** @test */
public function update_profile_successfully()
{
    $response = $this->put(route('profile.update'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);

    $response->assertRedirect();
    $this->assertTrue(session()->has('profile.updated'));
}
/** @test */
public function update_profile_fails_with_empty_data()
{
    $response = $this->from(route('profile.edit'))->put(route('profile.update'), [
        'name' => '',
        'email' => '',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHasErrors(['name', 'email']);
    
    $this->assertFalse(session()->has('profile.updated')); // assert FALSE karena tidak berhasil update
}

}
