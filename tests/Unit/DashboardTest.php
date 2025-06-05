<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test that an authenticated user can access the dashboard.
     *
     * @return void
     */
    public function test_show_dashboard()
    {
        // 1. Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. Act
        // Assuming your dashboard route is named 'dashboard' or is '/home' as per previous context
        // Let's assume it's 'home' as per your web.php for the dashboard view
        $response = $this->get(route('home')); // Or route('dashboard') if that's its actual name

        // 3. Assert
        $response->assertStatus(200);
        $response->assertViewIs('dashboard'); // Ensure this view name matches your controller
    }

    /**
     * Test that an unauthenticated user is redirected from the dashboard.
     *
     * @return void
     */
    public function test_unauthenticated_redirected()
    {
        // 1. Act
        // Assuming 'home' is protected by auth middleware
        $response = $this->get(route('home')); // Or route('dashboard')

        // 2. Assert
        $response->assertRedirect(route('login'));
    }

    /**
     * Test updating the user's profile successfully via DashboardController without changing password.
     *
     * @return void
     */
    public function test_successfully_update_without_password()
    {
        // 1. Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;

        $updateData = [
            'name' => $newName,
            'email' => $newEmail,
        ];

        // Assume you have a route for updateProfile, e.g., 'dashboard.profile.update'
        // If your DashboardController's updateProfile method is linked to a route like '/dashboard/profile/update'
        // and named 'dashboard.profile.update'
        // For now, let's assume a route name. You'll need to define this route in web.php
        // If this method is actually the same as the ProfileController's update, then this test is redundant
        // But based on your DashboardController code, it has its own updateProfile method.
        // Let's assume a route name 'dashboard.profile.update' mapped to DashboardController@updateProfile
        // If not, you'll need to adjust or create this route.
        // For this example, I'll assume you have a route like:
        // Route::post('/dashboard/profile/update', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');

        $response = $this->post(route('profile.update'), $updateData);
        $user->refresh();

        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
        $originalPasswordBeforeUpdate = User::find($user->id)->password;
        $this->assertEquals($originalPasswordBeforeUpdate, $user->password);
        $response->assertStatus(302); // Expecting a redirect after successful update
        // 3. Assert
        // The controller redirects to route('dashboard'), which might be named 'home' or 'dashboard'
        $response->assertRedirect(route('home')); // Or route('dashboard') if that's the name
        // $response->assertEquals('success', 'Profil berhasil diperbarui!');

    }

    /**
     * Test updating the user's profile successfully via DashboardController with password.
     *
     * @return void
     */
    public function test_successfully_update_with_password()
    {
        // 1. Arrange
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);
        $this->actingAs($user);

        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        $newPassword = 'new_secure_password_123';

        $updateData = [
            'name' => $newName,
            'email' => $newEmail,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        // Assuming route name 'dashboard.profile.update'
        $response = $this->post(route('profile.update'), $updateData);

        // 3. Assert
        $response->assertRedirect(route('home')); // Or route('dashboard')
        // $response->assertSessionHas('success', 'Profil berhasil diperbarui!');

        $user->refresh();

        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }
}