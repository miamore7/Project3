<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_form_is_accessible()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register'); // pastikan ada kata "Register" di form
    }

    /** @test */
 /** @test */

    /** @test */
    public function registration_fails_with_invalid_data()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'nomatch',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function user_cannot_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'johndoe@example.com',
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'John Duplicate',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
        $this->assertCount(1, User::all()); // hanya 1 user yang tersimpan
    }
}
