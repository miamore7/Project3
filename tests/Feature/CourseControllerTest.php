<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Buat admin user untuk testing
        $this->adminUser = User::factory()->create();
        
        // Jika menggunakan spatie/laravel-permission
        // $this->adminUser->assignRole('admin');
        
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function test_index_menampilkan_daftar_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->get(route('admin.courses.index'));

        $response->assertStatus(200);
        $response->assertViewHas('courses');
        $response->assertSee($course->nama_course);
    }

    /** @test */
    public function test_create_menampilkan_form_tambah_course()
    {
        $response = $this->get(route('admin.courses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.create');
    }

    /** @test */
    public function test_store_menyimpan_course_baru()
    {
        $data = [
            'nama_course' => 'Course Baru',
            'link_video' => 'https://example.com/video',
            'description' => 'Deskripsi course baru'
        ];

        $response = $this->post(route('admin.courses.store'), $data);

        $response->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseHas('courses', ['nama_course' => 'Course Baru']);
        $response->assertSessionHas('success');
    }

    /** @test */
    public function test_edit_menampilkan_form_edit()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->get(route('admin.courses.edit', $course));

        $response->assertStatus(200);
        $response->assertViewHas('course', $course);
    }

    /** @test */
    public function test_update_memperbarui_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $data = [
            'nama_course' => 'Course Updated',
            'link_video' => 'https://example.com/updated',
            'description' => 'Deskripsi updated'
        ];

        $response = $this->put(route('admin.courses.update', $course), $data);

        $response->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseHas('courses', ['nama_course' => 'Course Updated']);
        $response->assertSessionHas('success');
    }

    /** @test */
    public function test_show_menampilkan_detail_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->get(route('admin.courses.show', $course));

        $response->assertStatus(200);
        $response->assertViewHas(['course', 'subCourses']);
    }

    /** @test */
    public function test_destroy_menghapus_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->delete(route('admin.courses.destroy', $course));

        $response->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
        $response->assertSessionHas('success');
    }


  
}