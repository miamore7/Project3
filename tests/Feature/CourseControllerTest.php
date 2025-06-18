<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Route; // Import Route facade

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function admin_can_add_parent_course_successfully()
    {
        $courseData = [
            'nama_course' => 'Figma',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_1',
            'description' => 'Figma 1',
        ];

        $response = $this->post(route('admin.courses.store'), $courseData);

        $response->assertStatus(302); // Ensure redirect
        $this->assertDatabaseHas('courses', ['nama_course' => 'Figma']); // Use assertDatabaseHas
        $response->assertRedirect(route('admin.courses.index'))
            ->assertSessionHas('success', 'Course berhasil ditambahkan');
    }

    /** @test */
    public function admin_fails_to_add_course_with_empty_name()
    {
        $courseData = [
            'nama_course' => '',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_1',
            'description' => 'Figma 1',
        ];

        $response = $this->from(route('admin.courses.create'))
            ->post(route('admin.courses.store'), $courseData);

        $response->assertStatus(302); // Ensure redirect
        $response->assertRedirect(route('admin.courses.create'))
            ->assertSessionHasErrors(['nama_course']);
    }

    /** @test */
    public function admin_fails_to_add_course_with_invalid_youtube_link()
    {
        $courseData = [
            'nama_course' => 'Figma',
            'link_video' => '//youtu.be/33mkp1wJNRE?si=bQpe50hMk0fuveOZ',
            'description' => 'Figma 1',
        ];

        $response = $this->from(route('admin.courses.create'))
            ->post(route('admin.courses.store'), $courseData);

        $response->assertStatus(302); // Ensure redirect
        $response->assertRedirect(route('admin.courses.create'))
            ->assertSessionHasErrors(['link_video']);
    }

    /** @test */
    public function admin_can_edit_course_successfully()
    {
        $course = Course::factory()->create([
            'nama_course' => 'Figma',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_1',
            'description' => 'Figma 1',
        ]);

        $updatedData = [
            'nama_course' => 'Figma Updated',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_2',
            'description' => 'Figma 1 Updated',
        ];

        $response = $this->put(route('admin.courses.update', $course), $updatedData);

        $response->assertStatus(302); // Ensure redirect
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'nama_course' => 'Figma Updated',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_2',
            'description' => 'Figma 1 Updated',
        ]);
        $response->assertRedirect(route('admin.courses.index'))
            ->assertSessionHas('success', 'Course berhasil diperbarui');
    }
}