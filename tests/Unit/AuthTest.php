<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Menggunakan trait RefreshDatabase untuk mereset database setelah setiap test
    use WithFaker;       // Menggunakan trait WithFaker untuk data palsu jika diperlukan

    protected function setUp(): void
    {
        parent::setUp();
        // Event::fake(); // Fake events jika tidak ingin event handler sebenarnya dieksekusi
        Notification::fake(); // Fake notifications untuk mencegah pengiriman email/notifikasi sungguhan
    }

    //ConfirmPasswordController Tests 
    /** @test */
    public function show_confirm_password_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/password/confirm');

        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.confirm');
    }

    /** @test */
    public function redirect_to_login()
    {
        $response = $this->get('/password/confirm');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function confirm_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
        $this->actingAs($user);

        $response = $this->post('/password/confirm', [
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home'); // Sesuai $redirectTo
        $response->assertSessionHasNoErrors();
        $this->assertTrue(session()->has('auth.password_confirmed_at'));
    }

    //--- ForgotPasswordController Tests ---

    /** @test */
    public function show_reset_password_page()
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.email');
    }

    /** @test */
    public function send_reset_password_link()
    {
        $user = User::factory()->create();

        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);

        $response->assertRedirect('/'); // Default redirect setelah mengirim email reset
        $response->assertSessionHas('status'); // Pesan sukses
        Notification::assertSentTo(
            [$user],
            \Illuminate\Auth\Notifications\ResetPassword::class
        );
    }

    /** @test */
    public function failed_send_if_no_email()
    {
        $response = $this->post('/password/email', [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    //--- LoginController Tests ---

    /** @test */
    public function show_login_screen()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function if_already_login_redirected_from_login()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/login');
        $response->assertRedirect('/home');
    }

    /** @test */
    public function successfull_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/home');
    }

    /** @test */
    public function failed_login_invalid_credential()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email'); // Laravel biasanya mengembalikan error ke field 'email' untuk login gagal
    }

    /** @test */
    public function failed_login_invalid_email()
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/'); // Default redirect setelah logout
    }

    /** @test */
    public function guest_cant_logout()
    {
        // Mencoba logout sebagai guest, middleware 'auth' pada method logout akan redirect ke login
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
    }

    //--- RegisterController Tests ---

    /** @test */
    public function show_registration_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function if_already_login_redirected_from_regist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/register');
        $response->assertRedirect('/home');
    }

    /** @test */
    public function successfull_regist()
    {
        Event::fake([Registered::class]);

        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/home');
        Event::assertDispatched(Registered::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    /** @test */
    public function registration_needs_name()
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function registration_needs_email()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function registration_needs_valid_email()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function registration_needs_unique_email()
    {
        $existingUser = User::factory()->create(['email' => 'taken@example.com']);
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function registration_needs_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function registration_needs_password_min_8_characters()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
        $response->assertSessionHasErrors('password');
    }


    //--- ResetPasswordController Tests ---
    /** @test */
    public function fail_reset_password()
    {
        $user = User::factory()->create();

        $response = $this->post('/password/reset', [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ]);

        $response->assertSessionHasErrors('email'); // Laravel biasanya mengembalikan error ke field 'email' untuk token tidak valid
        $this->assertFalse(Hash::check('new-password123', $user->fresh()->password));
        $this->assertGuest();
    }
    /** @test */
    public function show_reset_password_screen()
    {
        $user = User::factory()->create();
        $token = Password::getRepository()->create($user);

        $response = $this->get("/password/reset/{$token}?email=" . urlencode($user->email));
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', $token);
        $response->assertViewHas('email', $user->email);
    }

    /** @test */
    public function password_can_be_reset_with_valid_token()
    {
        Event::fake([PasswordReset::class]);
        $user = User::factory()->create();
        $token = Password::getRepository()->create($user);

        $response = $this->post('/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertTrue(Hash::check('new-password123', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);
        Event::assertDispatched(PasswordReset::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }
}
