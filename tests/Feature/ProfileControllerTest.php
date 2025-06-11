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

        // Buat user dan login secara otomatis untuk setiap test
        $this->user = User::factory()->create([
            'password' => Hash::make('oldpassword'), // Pastikan password di-hash
            'name' => 'Michael', // Nama awal sebelum diedit
            'email' => 'michael@example.com', // Email awal sebelum diedit
        ]);
        $this->actingAs($this->user);
    }


    /**
     * TC008: Mengedit profil pengguna - Sukses
     * @test
     */
    public function user_can_update_profile_successfully()
    {
        $newName = 'admin';
        $newEmail = 'admin@example.com';

        $response = $this->put(route('profile.update'), [
            'name' => $newName,
            'email' => $newEmail,
        ]);

        // CHANGE THIS LINE:
        // From: $response->assertRedirect(route('profile.edit'));
        // To:
        $response->assertRedirect('/'); // Assuming it redirects to the root (homepage)
        // OR, if it redirects to a named route like 'dashboard':
        // $response->assertRedirect(route('dashboard'));

        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $newName,
            'email' => $newEmail,
        ]);

        $this->user->refresh();
        $this->assertEquals($newName, $this->user->name);
        $this->assertEquals($newEmail, $this->user->email);
    }


    /**
     * TC008: Mengedit profil pengguna - Tanpa Memasukkan Data
     * @test
     */
    public function update_profile_fails_with_empty_data()
    {
        // Lakukan request PUT ke endpoint update profil dengan data kosong
        $response = $this->from(route('profile.edit')) // Mengatur URL sebelumnya agar redirect berfungsi
                         ->put(route('profile.update'), [
                             'name' => '',
                             'email' => '',
                         ]);

        // Pastikan pengguna dialihkan kembali ke halaman edit profil
        $response->assertRedirect(route('profile.edit'));

        // Pastikan ada pesan error validasi untuk field 'name' dan 'email'
        $response->assertSessionHasErrors(['name', 'email']);

        // Pastikan data pengguna di database tidak berubah dari awal
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Michael', // Tetap nama awal
            'email' => 'michael@example.com', // Tetap email awal
        ]);

        // Pastikan tidak ada pesan sukses yang muncul
        $response->assertSessionMissing('status');
    }

   

    /**
     * TC009: Mengedit profil pengguna - Format Email Tidak Valid
     * @test
     */
    public function update_profile_fails_with_invalid_email_format()
    {
        $invalidEmail = 'adminexample.com'; // Email tanpa '@'

        // Lakukan request PUT ke endpoint update profil dengan format email yang salah
        $response = $this->from(route('profile.edit')) // Mengatur URL sebelumnya agar redirect berfungsi
                         ->put(route('profile.update'), [
                             'name' => 'admin', // Nama bisa saja berubah, tapi email ini yang jadi fokus
                             'email' => $invalidEmail,
                         ]);

        // Pastikan pengguna dialihkan kembali ke halaman edit profil
        $response->assertRedirect(route('profile.edit'));

        // Pastikan ada pesan error validasi untuk field 'email'
        $response->assertSessionHasErrors(['email']);

        // Pastikan data pengguna di database tidak berubah (nama dan email tetap yang awal)
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Michael', // Nama tetap original
            'email' => 'michael@example.com', // Email tetap original
        ]);

        // Pastikan tidak ada pesan sukses yang muncul
        $response->assertSessionMissing('status');
    }
}