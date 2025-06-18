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

    /** @test */
    public function registration_fails_with_existing_email()
    {
        // Buat user dengan email yang sudah ada
        User::factory()->create([
            'email' => 'ellen@example.com',
            'password' => 'password'
        ]);

        // Coba registrasi dengan email yang sama
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Pastikan ada error validasi pada field 'email'
        $response->assertSessionHasErrors(['email']);

        // Pastikan tidak ada user baru yang ditambahkan
        $this->assertDatabaseCount('users', 1);

        // Tambahan: Pastikan pengguna tidak terautentikasi
        // Karena registrasi gagal, tidak seharusnya ada user yang login
        $this->assertFalse(auth()->check()); // Opsi 1: Menggunakan assertFalse
        // atau
        // $this->assertGuest(); // Opsi 2: Menggunakan assertGuest (ini juga akan memeriksa jika user tidak login)
    }
}