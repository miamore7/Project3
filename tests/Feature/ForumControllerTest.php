<?php

namespace Tests\Feature;

use App\Models\Forum;
use App\Models\ForumUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User */
    protected $admin;
    /** @var \App\Models\User */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat user admin -> untuk mengakses fitur admin
        $this->admin = User::factory()->create(['role' => 'admin']);
        // Buat user biasa -> untuk mengakses fitur forum
        $this->user = User::factory()->create(['role' => 'user']);
    }

    /** @test */
    public function forum_can_be_created_with_valid_data()
    {
        // TC029 - Tambah Forum dengan data valid
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.forums.store'), [
            'name' => 'Forum Laravel',
            'description' => 'Forum diskusi Laravel',
        ]);

        $response->assertRedirect(route('admin.forums.index'));

        // Mencari dari database
        $this->assertDatabaseHas('forums', [
            'name' => 'Forum Laravel',
            'description' => 'Forum diskusi Laravel',
        ]);
    }

    /** @test */
    public function forum_creation_fails_with_missing_name()
    {
        // TC030 - Tambah Forum tanpa mengisi nama
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.forums.store'), [
            // 'id' => 1, // tanpa id bisa kok
            // 'name' => null, // Nama kosong
            'description' => 'Tanpa nama',
        ]);

        $response->assertSessionHasErrors('name'); //jadi name kalo mau pass
        $this->assertDatabaseCount('forums', 0);
    }

    // test untuk edit nama forum
    /** @test */
    public function admin_can_edit_forum_name()
    {
        // TC031 - Edit nama forum
        $this->actingAs($this->admin);

        $forum = Forum::factory()->create([
            'name' => 'Forum Pemilik',
            'description' => 'Deskripsi lama',
        ]);

        $response = $this->put(route('admin.forums.update', $forum), [
            'name' => 'Forum Baru',
            'description' => 'Deskripsi baru',
        ]);

        $response->assertRedirect(route('admin.forums.index'));

        // Mencari dari database
        $this->assertDatabaseHas('forums', [
            'name' => 'Forum Baru',
            'description' => 'Deskripsi baru',
        ]);

        // Memastikan nama lama tidak ada lagi
        $this->assertDatabaseMissing('forums', [
            'name' => 'Forum Pemilik',
            'description' => 'Deskripsi lama',
        ]);
    }

    // test untuk approve request user bergabung ke forum
    /** @test */
    // test untuk approve request user bergabung ke forum
    /** @test */
    public function admin_can_approve_user_joining_forum()
    {
        // TC032 - Admin menyetujui permintaan bergabung forum
        $this->actingAs($this->admin);

        $forum = Forum::factory()->create();
        $user = User::factory()->create();

        // Simulasi permintaan bergabung ke forum dari user
        $request = ForumUserRequest::create([
            'forum_id' => $forum->id,
            'user_id' => $user->id,
            'status' => 'rejected',
        ]);

        $response = $this->post(route('admin.forum.requests.approve', $request->id));

        // since using back()->with('success', 'User approved.');
        $response->assertRedirect();
        $response->assertSessionHas('success', 'User approved.');

        $this->assertDatabaseHas('forum_user_requests', [
            'id' => $request->id,
            'status' => 'approved',
        ]);

        $this->assertTrue($forum->members()->where('user_id', $user->id)->exists());
    }


    // test untuk menolak permintaan bergabung user ke forum
    /** @test */
    public function admin_can_reject_user_joining_forum()
    {
        // TC033 - Admin menolak permintaan bergabung forum
        $this->actingAs($this->admin);

        $forum = Forum::factory()->create();
        $user = User::factory()->create();

        // Simulasi permintaan bergabung ke forum dari user
        $request = ForumUserRequest::create([
            'forum_id' => $forum->id,
            'user_id' => $user->id,
            'status' => 'rejected',
        ]);

        $response = $this->post(route('admin.forum.requests.reject', $request->id));

        // since using back()->with('success', 'User rejected.');
        $response->assertRedirect();
        $response->assertSessionHas('success', 'User rejected.');

        $this->assertDatabaseHas('forum_user_requests', [
            'id' => $request->id,
            'status' => 'rejected',
        ]);

        // Memastikan user tidak menjadi anggota forum
        $this->assertFalse($forum->members()->where('user_id', $user->id)->exists());
    }

    /** @test */
    public function a_member_can_send_message_in_forum()
    {
        // Create a forum and make the user a member
        $forum = Forum::factory()->create();
        $forum->members()->attach($this->user->id);

        $messageContent = 'Hello, this is a test message.';

        $response = $this->actingAs($this->user)->post(route('user.forums.chat.send', $forum->id), [
            'message' => $messageContent,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('forum_messages', [
            'forum_id' => $forum->id,
            'user_id' => $this->user->id,
            'message' => $messageContent,
        ]);

    }

}
