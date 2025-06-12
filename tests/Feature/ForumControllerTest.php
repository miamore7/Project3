<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User */
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat user admin
        $this->admin = User::factory()->create(['role' => 'admin']);
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
            'description' => 'Tanpa nama',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('forums', 0);
    }
}
