<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

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

    /**
     * TC-010: Admin dapat menambahkan induk course dengan data lengkap (Sukses).
     * @test
     */
    public function admin_can_add_parent_course_successfully()
    {
        $courseData = [
            'nama_course' => 'Figma',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_1',
            'description' => 'Figma 1',
        ];

        $response = $this->post(route('admin.courses.store'), $courseData);

        // --- ASSERT TRUE ---
        // Pastikan data berhasil ditambahkan ke database (berarti hasilnya TRUE bahwa ada data tersebut)
        $this->assertTrue(Course::where('nama_course', 'Figma')->exists(), 'Course should be created in the database.');
        // Pastikan admin tetap terautentikasi
        $this->assertTrue(auth()->check(), 'Admin should remain authenticated.');

        // --- ASSERT FALSE ---
        // Pastikan tidak ada error validasi
        // Use assertSessionHasNoErrors() instead of checking ->session()->hasErrors()
      $response->assertSessionHasNoErrors(); // No arguments allowed
        // Pastikan tidak ada course dengan nama yang tidak relevan (misal: "Dummy Course")
        $this->assertFalse(Course::where('nama_course', 'Dummy Course')->exists(), 'No dummy course should exist.');


        // Redirect dan pesan sukses lainnya
        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil ditambahkan');
    }

    /**
     * TC-010: Admin gagal menambahkan induk course jika nama course kosong.
     * @test
     */
    public function admin_fails_to_add_parent_course_with_empty_name()
    {
        $courseData = [
            'nama_course' => '',
            'link_video' => 'https://www.youtube.com/watch?v=youtube_video_id_1',
            'description' => 'Figma 1',
        ];

        $response = $this->from(route('admin.courses.create'))
                         ->post(route('admin.courses.store'), $courseData);

        // --- ASSERT TRUE ---
        // Pastikan admin tetap terautentikasi
        $this->assertTrue(auth()->check(), 'Admin should remain authenticated.');
        // Pastikan ada error validasi untuk 'nama_course'
        // Use assertSessionHasErrors() directly
        $response->assertSessionHasErrors('nama_course', 'Validation error for nama_course should be present.');

        // --- ASSERT FALSE ---
        // Pastikan tidak ada course yang dibuat
        $this->assertFalse(Course::where('description', 'Figma 1')->exists(), 'No course should be created with empty name.');
        // Pastikan tidak ada pesan sukses
        // Use assertSessionMissing() directly
    $response->assertSessionMissing('success'); // Only provide the session key


        // Redirect dan error validasi lainnya
        $response->assertRedirect(route('admin.courses.create'));
        // This is redundant after assertSessionHasErrors('nama_course') but kept for clarity if preferred
        $response->assertSessionHasErrors(['nama_course']);
    }

    /**
     * TC-011: Admin gagal menambahkan induk course jika format link video YouTube salah.
     * @test
     */
    public function admin_fails_to_add_parent_course_with_invalid_youtube_link_format()
    {
        $courseData = [
            'nama_course' => 'Figma',
            'link_video' => '//youtu.be/33mkp1wJNRE?si=bQpe50hMk0fuveOZ',
            'description' => 'Figma 1',
        ];

        $response = $this->from(route('admin.courses.create'))
                         ->post(route('admin.courses.store'), $courseData);

        // --- ASSERT TRUE ---
        // Pastikan admin tetap terautentikasi
        $this->assertTrue(auth()->check(), 'Admin should remain authenticated.');
        // Pastikan ada error validasi untuk 'link_video'
        // Use assertSessionHasErrors() directly
        $response->assertSessionHasErrors('link_video', 'Validation error for link_video should be present.');

        // --- ASSERT FALSE ---
        // Pastikan tidak ada course yang dibuat
        $this->assertFalse(Course::where('nama_course', 'Figma')->exists(), 'No course should be created with invalid link.');
        // Pastikan tidak ada pesan sukses
        // Use assertSessionMissing() directly
       $response->assertSessionMissing('success'); // Only provide the session key

        // Redirect dan error validasi lainnya
        $response->assertRedirect(route('admin.courses.create'));
        // This is redundant after assertSessionHasErrors('link_video') but kept for clarity if preferred
        $response->assertSessionHasErrors(['link_video']);
    }

    /**
     * Pastikan non-admin tidak dapat menambahkan course.
     * @test
     */
}