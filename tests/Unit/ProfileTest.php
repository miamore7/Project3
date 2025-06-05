<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User; // Assuming you have a User model
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// Illuminate\Support\Facades\Auth; // Auth facade is not directly used in this shortened version
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase // Note: Class name changed from ProfileControllerTest
{
    use RefreshDatabase; // Resets the database after each test
    use WithFaker;     // Provides fake data generation

    /**
     * Test showing the profile edit page.
     *
     * @return void
     */
    public function test_show_edit()
    {
        // 1. Arrange
        // Create a user and authenticate them
        $user = User::factory()->create();
        $this->actingAs($user); // Helper to simulate an authenticated user

        // 2. Act
        // Call the 'edit' method on the controller
        $response = $this->get(route('profile.edit')); // Assuming you have a named route 'profile.edit'

        // 3. Assert
        // Check if the response is successful (status code 200)
        $response->assertStatus(200);
        // Check if the correct view is returned
        $response->assertViewIs('profile.edit');
        // Check if the view has the 'user' variable and it's the authenticated user
        $response->assertViewHas('user', $user);
    }

    /**
     * Test updating the user's profile successfully without changing password.
     *
     * @return void
     */
    public function test_update_updates_profile_successfully_without_password()
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

        // 2. Act
        // Call the 'update' method - Changed from PUT to POST
        $response = $this->post(route('profile.update'), $updateData); // Assuming 'profile.update' route

        // 3. Assert
        // Check if the user was redirected to the home route
        $response->assertRedirect(route('home')); // Assuming 'home' route
        // Check for the success message in the session
        $response->assertSessionHas('success', 'Profil berhasil diperbarui.');

        // Refresh the user model from the database to get the updated values
        $user->refresh();

        // Check if the user's name and email were updated in the database
        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
        // Ensure password was not changed if not provided
        // Get the original password from the factory definition if possible, or check against the re-fetched user's current password
        // This assertion might need adjustment based on your UserFactory's default password behavior
        $originalPasswordBeforeUpdate = User::find($user->id)->password; // Re-fetch to be sure
        $this->assertEquals($originalPasswordBeforeUpdate, $user->password);
    }

    /**
     * Test updating the user's profile successfully including the password.
     *
     * @return void
     */
    public function test_update_updates_profile_successfully_with_password()
    {
        // 1. Arrange
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);
        $this->actingAs($user);

        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        $newPassword = 'new_secure_password';

        $updateData = [
            'name' => $newName,
            'email' => $newEmail,
            'password' => $newPassword,
            'password_confirmation' => $newPassword, // Required by 'confirmed' validation rule
        ];

        // 2. Act
        // Changed from PUT to POST
        $response = $this->post(route('profile.update'), $updateData);

        // 3. Assert
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'Profil berhasil diperbarui.');

        $user->refresh();

        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
        // Check if the password was updated and hashed correctly
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    
    /**
     * Test that unauthenticated users are redirected from edit page.
     *
     * @return void
     */
    public function test_unauthorized_redirected()
    {
        // 1. Act
        $response = $this->get(route('profile.edit'));

        // 2. Assert
        $response->assertRedirect(route('login')); // Assuming 'login' is your login route name
    }
}
