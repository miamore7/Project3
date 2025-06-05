<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_successfully()
    {
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'securepassword',
            'password_confirmation' => 'securepassword',
        ]);

        $response->assertRedirect(route('login')); // ubah jika perlu
        $this->assertDatabaseHas('users', ['email' => 'janedoe@example.com']);
        $this->assertTrue(auth()->check());
    }

    /** @test */
    public function registration_fails_with_empty_input()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertFalse(auth()->check());
        $this->assertCount(0, User::all());
    }
}
