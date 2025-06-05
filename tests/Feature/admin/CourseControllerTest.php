<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    // protected User $regularUser; // Bisa di-uncomment jika ada test yang memerlukan user non-admin

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat adminUser dengan 'role' => 'admin' sesuai AdminMiddleware Anda
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            // Tambahkan field lain yang mungkin diperlukan oleh factory User Anda agar valid
            // seperti 'email_verified_at' => now(), dll.
        ]);

        // Jika Anda punya test yang memerlukan user biasa, buat di sini
        // $this->regularUser = User::factory()->create([
        //     'role' => 'user', // Atau role lain yang bukan 'admin'
        // ]);
    }

    /**
     * @test
     * Test 1: Admin dapat melihat halaman index courses.
     */
    public function admin_can_view_courses_index()
    {
        Course::factory()->count(3)->create(['idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.courses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.index');
        $response->assertViewHas('courses');
    }

    /**
     * @test
     * Test 2: Admin dapat menyimpan course baru.
     */
    public function admin_can_store_a_new_course()
    {
        $courseData = [
            'nama_course' => 'Kursus Tes Simpan Baru',
            'link_video' => 'https://contoh.com/video-tes.mp4',
            'description' => 'Deskripsi untuk kursus tes simpan.',
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post(route('admin.courses.store'), $courseData);

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil ditambahkan');
        $this->assertDatabaseHas('courses', [
            'nama_course' => 'Kursus Tes Simpan Baru',
            'idUser' => $this->adminUser->id,
        ]);
    }

    /**
     * @test
     * Test 3: Validasi gagal jika nama_course tidak diisi saat menyimpan.
     */
    public function store_course_requires_nama_course()
    {
        $response = $this->actingAs($this->adminUser)
                         ->post(route('admin.courses.store'), [
                            'nama_course' => '', // nama_course sengaja dikosongkan
                            'description' => 'Deskripsi saja',
                         ]);

        $response->assertSessionHasErrors('nama_course');
    }

    /**
     * @test
     * Test 4: Admin dapat memperbarui course yang sudah ada.
     */
    public function admin_can_update_a_course()
    {
        $course = Course::factory()->create([
            'nama_course' => 'Nama Kursus Awal',
            'idUser' => $this->adminUser->id
        ]);

        $updatedData = [
            'nama_course' => 'Nama Kursus Telah Diperbarui',
            'link_video' => 'https://contoh.com/video-baru.mp4',
            'description' => 'Deskripsi telah diperbarui.',
        ];

        $response = $this->actingAs($this->adminUser)
                         ->put(route('admin.courses.update', $course), $updatedData);

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil diperbarui');
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'nama_course' => 'Nama Kursus Telah Diperbarui',
        ]);
    }

    /**
     * @test
     * Test 5: Admin dapat menghapus course.
     */
    public function admin_can_delete_a_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->delete(route('admin.courses.destroy', $course));

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil dihapus');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    /**
     * @test
     * Test 6: Tamu tidak bisa mengakses halaman index courses admin.
     */
    public function guest_cannot_access_courses_index()
    {
        // Tidak perlu $this->actingAs() karena ini adalah tamu
        $response = $this->get(route('admin.courses.index'));

        // Menggunakan helper route('login') lebih aman jika path login Anda berubah
        $response->assertRedirect(route('login'));
    }
}