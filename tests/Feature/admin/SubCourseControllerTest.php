<?php

namespace Tests\Feature\Admin;

use App\Models\Course;
use App\Models\SubCourse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubCourseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->course = Course::factory()->create();
    }

    /** @test */
    public function store_subcourse_successfully()
    {
        $response = $this->post(route('sub-courses.store'), [
            'nama_course' => 'SubCourse Test',
            'link_video' => 'https://example.com/video',
            'description' => 'Deskripsi SubCourse',
            'course_id' => $this->course->id,
        ]);

        $response->assertRedirect(route('sub-courses.index'));
        $response->assertSessionHas('success', 'SubCourse berhasil ditambahkan');

        $this->assertDatabaseHas('sub_courses', [
            'nama_course' => 'SubCourse Test',
            'course_id' => $this->course->id,
        ]);
    }

    /** @test */
    public function store_subcourse_fails_when_data_is_empty()
    {
        $response = $this->post(route('sub-courses.store'), []);

        $response->assertSessionHasErrors(['nama_course', 'course_id']);
    }

    /** @test */
    public function update_subcourse_successfully()
    {
        $subCourse = SubCourse::factory()->create([
            'course_id' => $this->course->id,
            'idUser' => $this->user->id,
        ]);

        $response = $this->put(route('sub-courses.update', $subCourse->id), [
            'nama_course' => 'Nama Baru',
            'link_video' => 'https://example.com/newvideo',
            'description' => 'Deskripsi baru',
            'course_id' => $this->course->id,
        ]);

        $response->assertRedirect(route('sub-courses.index'));
        $response->assertSessionHas('success', 'SubCourse berhasil diperbarui');

        $this->assertDatabaseHas('sub_courses', [
            'id' => $subCourse->id,
            'nama_course' => 'Nama Baru',
        ]);
    }

    /** @test */
    public function update_subcourse_fails_when_data_is_empty()
    {
        $subCourse = SubCourse::factory()->create([
            'course_id' => $this->course->id,
            'idUser' => $this->user->id,
        ]);

        // Kirim data kosong, harus error karena 'nama_course' wajib
        $response = $this->put(route('sub-courses.update', $subCourse->id), []);

        $response->assertSessionHasErrors(['nama_course']);
    }

    /** @test */
    public function destroy_subcourse_successfully()
    {
        $subCourse = SubCourse::factory()->create([
            'course_id' => $this->course->id,
            'idUser' => $this->user->id,
        ]);

        $response = $this->delete(route('sub-courses.destroy', $subCourse->id));

        $response->assertRedirect(route('sub-courses.index'));
        $response->assertSessionHas('success', 'SubCourse berhasil dihapus');

        $this->assertDatabaseMissing('sub_courses', [
            'id' => $subCourse->id,
        ]);
    }
}
