<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;    // Import model Course
use App\Models\SubCourse; // Import model SubCourse
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SubCourseControllerTest extends TestCase
{
    use RefreshDatabase; // Mengatur ulang database untuk setiap tes

    protected $adminUser;
    protected $parentCourse;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat pengguna admin dan mengautentikasinya untuk tes yang memerlukan hak akses admin
        $this->adminUser = User::factory()->create([
            'role' => 'admin', // Asumsikan 'admin' role diperlukan
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $this->actingAs($this->adminUser); // Log in user admin

        // Membuat induk course, karena sub-course harus memiliki induk course
        // Penting: Gunakan 'idUser' sesuai dengan kolom di tabel 'courses' Anda
        $this->parentCourse = Course::factory()->create([
            'nama_course' => 'Figma Course',
            'idUser' => $this->adminUser->id, // Menggunakan 'idUser' sesuai controller Anda
        ]);
    }

    

    /**
     * TC-012: Admin berhasil menambahkan Sub Course dengan data lengkap.
     * @test
     */
    public function admin_can_add_sub_course_successfully()
    {
        $subCourseData = [
            'nama_course' => 'Figma 2',
            'link_video' => 'https://www.youtube.com/watch?v=validID123', // Gunakan URL YouTube yang valid
            'description' => 'Figma 1',
            'course_id' => $this->parentCourse->id, // Gunakan ID dari induk course yang dibuat
        ];

        // Lakukan request POST ke endpoint penyimpanan sub course
        $response = $this->post(route('admin.sub-courses.store'), $subCourseData);

        // --- ASSERT TRUE ---
        // Pastikan SubCourse berhasil dibuat di database
        $this->assertTrue(
            SubCourse::where('nama_course', 'Figma 2')->exists(),
            'SubCourse seharusnya dibuat di database.'
        );
        // Pastikan admin tetap terautentikasi setelah operasi sukses
        $this->assertTrue(auth()->check(), 'Admin seharusnya tetap terautentikasi.');

        // --- ASSERT FALSE ---
        // Pastikan tidak ada error validasi di session
        $response->assertSessionHasNoErrors();
        // Pastikan tidak ada SubCourse dengan nama yang tidak relevan yang dibuat
        $this->assertFalse(
            SubCourse::where('nama_course', 'NonExistent SubCourse')->exists(),
            'Tidak seharusnya ada SubCourse tidak relevan yang dibuat.'
        );

        // Assertions tambahan:
        $response->assertRedirect(route('sub-courses.index')); // Cek redirect ke index sub course
        $response->assertSessionHas('success', 'SubCourse berhasil ditambahkan'); // Cek flash message
    }

    

    /**
     * TC-012: Admin gagal menambahkan Sub Course dengan link YouTube tidak valid.
     * @test
     */
    public function admin_fails_to_add_sub_course_with_invalid_youtube_link()
    {
        $subCourseData = [
            'nama_course' => 'Figma 2',
            'link_video' => 'youtu.be/33mkp1wJNRE?si=bQpe50hMk0fuveOZ', // Format tidak valid (tanpa skema http/https)
            'description' => 'Figma 1',
            'course_id' => $this->parentCourse->id,
        ];

        // Lakukan request POST dari halaman create untuk menangani redirect dengan error
        $response = $this->from(route('admin.sub-courses.create'))
                         ->post(route('admin.sub-courses.store'), $subCourseData);

        // --- ASSERT TRUE ---
        // Pastikan ada error validasi untuk 'link_video'
        $response->assertSessionHasErrors('link_video');
        // Pastikan admin tetap terautentikasi
        $this->assertTrue(auth()->check(), 'Admin seharusnya tetap terautentikasi.');

        // --- ASSERT FALSE ---
        // Pastikan tidak ada SubCourse baru yang ditambahkan ke database
        $this->assertFalse(
            SubCourse::where('nama_course', 'Figma 2')->exists(),
            'Tidak seharusnya ada SubCourse yang dibuat dengan link video tidak valid.'
        );
        // Pastikan tidak ada pesan sukses di session
        $response->assertSessionMissing('success');

        // Assertions tambahan:
        $response->assertRedirect(route('admin.sub-courses.create')); // Redirect kembali ke halaman form
        $response->assertSessionHasErrors(['link_video']); // Cek error spesifik
        $this->assertDatabaseCount('sub_courses', 0); // Pastikan tabel sub_courses kosong
    }

    

    /**
     * TC-013: Admin gagal menambahkan Sub Course tanpa memilih induk course atau mengisi nama.
     * @test
     */
    public function admin_fails_to_add_sub_course_with_missing_required_data()
    {
        $subCourseData = [
            'nama_course' => '',        // Kosong
            'link_video' => 'https://www.youtube.com/watch?v=validID456',
            'description' => 'Figma 1',
            'course_id' => null,        // Tidak memilih induk course (atau null)
        ];

        // Lakukan request POST dari halaman create untuk menangani redirect dengan error
        $response = $this->from(route('admin.sub-courses.create'))
                         ->post(route('admin.sub-courses.store'), $subCourseData);

        // --- ASSERT TRUE ---
        // Pastikan ada error validasi untuk 'nama_course' dan 'course_id'
        $response->assertSessionHasErrors(['nama_course', 'course_id']);
        // Pastikan admin tetap terautentikasi
        $this->assertTrue(auth()->check(), 'Admin seharusnya tetap terautentikasi.');

        // --- ASSERT FALSE ---
        // Pastikan tidak ada SubCourse baru yang ditambahkan ke database
        $this->assertFalse(
            SubCourse::where('description', 'Figma 1')->exists(),
            'Tidak seharusnya ada SubCourse yang dibuat dengan data wajib yang hilang.'
        );
        // Pastikan tidak ada pesan sukses di session
        $response->assertSessionMissing('success');

        // Assertions tambahan:
        $response->assertRedirect(route('admin.sub-courses.create')); // Redirect kembali ke halaman form
        $response->assertSessionHasErrors(['nama_course', 'course_id']); // Cek error spesifik
        $this->assertDatabaseCount('sub_courses', 0); // Pastikan tabel sub_courses kosong
    }


}
