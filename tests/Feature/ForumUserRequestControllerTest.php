<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\ForumUserRequest;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForumUserRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the index page correctly displays pending forum user requests.
     */
    public function test_index_displays_pending_requests()
    {
        // Create a new forum and user using their factories
        $forum = Forum::factory()->create();
        $user = User::factory()->create();

        // Create a pending ForumUserRequest associated with the created forum and user
        $request = ForumUserRequest::factory()->create([
            'forum_id' => $forum->id,
            'user_id' => $user->id,
            'status' => 'pending', // Ensure the request starts as pending
        ]);

        // Make a GET request to the forum requests route
        $response = $this->get(route('forum.requests'));

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);
        // Assert that the correct view is returned
        $response->assertViewIs('admin.forums.requests');
        // Assert that the view has a 'requests' variable and it contains our specific pending request
        $response->assertViewHas('requests', function ($requests) use ($request) {
            return $requests->contains($request);
        });
    }

    /**
     * Test the approval process for a forum user request.
     */
    public function test_approve_request()
    {
        // Create a new forum and user
        $forum = Forum::factory()->create();
        $user = User::factory()->create();

        // Create a pending ForumUserRequest that will be approved
        $request = ForumUserRequest::factory()->create([
            'forum_id' => $forum->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        // Make a POST request to the approve route for the specific request
        $response = $this->post(route('forum.requests.approve', $request->id));

        // Assert that the response redirects (typical for successful form submissions)
        $response->assertRedirect();
        // Assert that a success message is flashed to the session
        $response->assertSessionHas('success', 'User approved.');

        // Assert that the database record for the request has been updated to 'approved'
        $this->assertDatabaseHas('forum_user_requests', [
            'id' => $request->id,
            'status' => 'approved',
        ]);

        // ⭐ ASSERT TRUE: Verify that the user has now been added as a member of the forum.
        // This is a direct check on the relationship, ensuring the core action (membership) occurred.
        $this->assertTrue($forum->members()->where('user_id', $user->id)->exists(),
            'User should be a member of the forum after approval.');
    }

    /**
     * Test the rejection process for a forum user request.
     */
    public function test_reject_request()
    {
        // Create a pending ForumUserRequest to be rejected
        $request = ForumUserRequest::factory()->create(['status' => 'pending']);

        // Make a POST request to the reject route for the specific request
        $response = $this->post(route('forum.requests.reject', $request->id));

        // Assert that the response redirects
        $response->assertRedirect();
        // Assert that a success message is flashed to the session
        $response->assertSessionHas('success', 'User rejected.');

        // Assert that the database record for the request has been updated to 'rejected'
        $this->assertDatabaseHas('forum_user_requests', [
            'id' => $request->id,
            'status' => 'rejected',
        ]);
        // Note: No assertTrue/assertFalse needed here as rejection doesn't involve adding/removing membership.
        // The assertDatabaseHas already confirms the primary state change.
    }

    /**
     * Test the functionality to kick a user from a forum.
     */
    public function test_kick_user_from_forum()
    {
        // Create a new forum and user
        $forum = Forum::factory()->create();
        $user = User::factory()->create();

        // Attach the user to the forum as a member first to simulate an existing member
        $forum->members()->attach($user->id);

        // ⭐ ASSERT TRUE: Verify that the user is initially a member of the forum.
        // This confirms our test setup is correct before the kick action.
        $this->assertTrue($forum->members()->where('user_id', $user->id)->exists(),
            'User should initially be a member of the forum.');

        // Make a DELETE request to the kick route for the specific forum and user
        $response = $this->delete(route('forum.kick', [$forum->id, $user->id]));

        // Assert that the response redirects
        $response->assertRedirect();
        // Assert that a success message is flashed to the session
        $response->assertSessionHas('success', 'User kicked from forum.');

        // ⭐ ASSERT FALSE: Verify that the user is no longer a member of the forum after being kicked.
        // This is a direct check on the relationship, ensuring the core action (removal) occurred.
        $this->assertFalse($forum->members()->where('user_id', $user->id)->exists(),
            'User should no longer be a member of the forum after being kicked.');
    }
}
