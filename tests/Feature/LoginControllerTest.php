<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase; // Menggunakan RefreshDatabase untuk membersihkan database setelah setiap test

    /** @test */
    // TC001: Login dengan kredensial valid
    public function login_succeeds_with_valid_credentials()
    {
        // Persiapan: Buat user dengan kredensial yang akan digunakan
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456'), // Gunakan bcrypt untuk mengenkripsi password
        ]);

        // Aksi: Kirim request POST ke endpoint '/login' dengan kredensial valid
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => '123456',
        ]);

        // Verifikasi:
        // 1. Pastikan pengguna diarahkan ke halaman dashboard (misalnya, route 'home')
        $response->assertRedirect('/user/dashboard'); // Sesuaikan dengan route dashboard yang sebenarnya
        // 2. Pastikan pengguna terautentikasi sebagai user yang baru saja dibuat
        $this->assertAuthenticatedAs($user);
        // 3. Opsional: Pastikan sesi terautentikasi
        $this->assertTrue(auth()->check());
    }

    /** @test */
    // TC002: Login dengan kredensial kosong
    public function login_fails_with_empty_credentials()
    {
        // Aksi: Kirim request POST ke endpoint '/login' dengan email dan password kosong
        // Menggunakan from('/login') untuk mensimulasikan asal request dari halaman login,
        // sehingga Laravel akan mengembalikan ke halaman login dengan error validasi.
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        // Verifikasi:
        // 1. Pastikan pengguna diarahkan kembali ke halaman login
        $response->assertRedirect('/login');
        // 2. Pastikan sesi memiliki error validasi untuk 'email' dan 'password'
        $response->assertSessionHasErrors(['email', 'password']);
        // 3. Pastikan tidak ada pengguna yang terautentikasi (masih guest)
        $this->assertGuest();
        $this->assertFalse(auth()->check());
    }

    /** @test */
    // TC003: Login dengan email yang tidak terdaftar
    public function login_fails_with_unregistered_email()
    {
        // Aksi: Kirim request POST ke endpoint '/login' dengan email yang tidak terdaftar
        // dan password (bisa apa saja karena email tidak terdaftar).
        $response = $this->from('/login')->post('/login', [
            'email' => 'user1@gmail.com', // Email ini tidak ada di database
            'password' => '123456',
        ]);

        // Verifikasi:
        // 1. Pastikan pengguna diarahkan kembali ke halaman login
        $response->assertRedirect('/login');
        // 2. Pastikan sesi memiliki error validasi pada field 'email'
        //    (Laravel biasanya akan menampilkan error ini jika kredensial tidak cocok)
        $response->assertSessionHasErrors('email');
        // 3. Pastikan tidak ada pengguna yang terautentikasi (masih guest)
        $this->assertGuest();
        $this->assertFalse(auth()->check());
    }
}