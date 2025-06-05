<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
// use App\Models\SubCourse; // Uncomment jika diperlukan untuk relasi atau seeding di 'show'

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $regularUser; // User biasa untuk test 'like'

    protected function setUp(): void
    {
        parent::setUp();

        // --------------------------------------------------------------------
        // PENTING: Sesuaikan pembuatan adminUser ini dengan bagaimana
        // aplikasi Anda mengidentifikasi seorang admin.
        // Tanpa ini, user mungkin tidak diotorisasi untuk mengakses route admin,
        // menyebabkan redirect (status 302) bukan 200 atau redirect ke halaman admin.
        // --------------------------------------------------------------------

        // Contoh 1: Jika Anda memiliki kolom 'is_admin' (boolean) di tabel users
        $this->adminUser = User::factory()->create([
            // 'is_admin' => true, //  <-- SESUAIKAN INI! Uncomment dan pastikan ini benar.
            // 'email' => 'admin@example.com', // Opsional: email spesifik
        ]);

        // Contoh 2: Jika Anda menggunakan sistem Roles & Permissions (misal Spatie/laravel-permission)
        // 1. Pastikan Anda sudah membuat role 'admin' (misalnya via seeder atau manual).
        //    // \Spatie\Permission\Models\Role::create(['name' => 'admin']); // Jalankan sekali jika belum ada
        // 2. Assign role tersebut ke user:
        // if ($this->adminUser) { // Pastikan $adminUser sudah di-create
        //     // $this->adminUser->assignRole('admin'); // <-- SESUAIKAN INI! Pastikan nama role 'admin' sudah ada.
        // }


        // User biasa untuk fitur 'like'
        $this->regularUser = User::factory()->create();
    }

    /** @test */
    public function admin_can_view_courses_index()
    {
        // Pastikan adminUser Anda dikenali sebagai admin oleh middleware
        Course::factory()->count(3)->create(['idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.courses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.index');
        $response->assertViewHas('courses');
    }

    /** @test */
    public function admin_can_view_create_course_page()
    {
        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.courses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.create');
    }

    /** @test */
    public function admin_can_store_a_new_course()
    {
        $courseData = [
            'nama_course' => 'Kursus Baru yang Unik Sekali Untuk Store',
            'link_video' => 'https://contoh.com/video-kursus.mp4',
            'description' => 'Deskripsi untuk kursus baru ini.',
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post(route('admin.courses.store'), $courseData);

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil ditambahkan');
        $this->assertDatabaseHas('courses', [
            'nama_course' => 'Kursus Baru yang Unik Sekali Untuk Store',
            'link_video' => 'https://contoh.com/video-kursus.mp4',
            'description' => 'Deskripsi untuk kursus baru ini.',
            'idUser' => $this->adminUser->id,
        ]);
    }

    /** @test */
    public function store_course_requires_nama_course()
    {
        $response = $this->actingAs($this->adminUser)
                         ->post(route('admin.courses.store'), ['nama_course' => '']);

        $response->assertSessionHasErrors('nama_course');
    }

    /** @test */
    public function store_course_requires_unique_nama_course()
    {
        Course::factory()->create(['nama_course' => 'Nama Kursus Sudah Ada Untuk Store', 'idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->post(route('admin.courses.store'), ['nama_course' => 'Nama Kursus Sudah Ada Untuk Store']);

        $response->assertSessionHasErrors('nama_course');
    }

    /** @test */
    public function store_course_link_video_must_be_a_valid_url_if_provided()
    {
        $response = $this->actingAs($this->adminUser)
                         ->post(route('admin.courses.store'), [
                            'nama_course' => 'Kursus Validasi URL Store',
                            'link_video' => 'ini-bukan-url-valid'
                         ]);

        $response->assertSessionHasErrors('link_video');
    }

    /** @test */
    public function admin_can_view_edit_course_page()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.courses.edit', $course));

        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.edit');
        $response->assertViewHas('course', $course);
    }

    /** @test */
    public function admin_can_update_a_course()
    {
        $course = Course::factory()->create([
            'nama_course' => 'Nama Kursus Lama Untuk Diupdate',
            'idUser' => $this->adminUser->id
        ]);

        $updatedData = [
            'nama_course' => 'Nama Kursus Baru Setelah Update yang Unik',
            'link_video' => 'https://contoh.com/video-update.mp4',
            'description' => 'Deskripsi kursus setelah diupdate.',
        ];

        $response = $this->actingAs($this->adminUser)
                         ->put(route('admin.courses.update', $course), $updatedData);

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil diperbarui');
        $this->assertDatabaseHas('courses', array_merge(['id' => $course->id], $updatedData));
    }

    /** @test */
    public function update_course_requires_nama_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);
        $response = $this->actingAs($this->adminUser)
                         ->put(route('admin.courses.update', $course), ['nama_course' => '']);

        $response->assertSessionHasErrors('nama_course');
    }

    /** @test */
    public function update_course_nama_course_must_be_unique_except_self()
    {
        $existingCourse = Course::factory()->create(['nama_course' => 'Nama Kursus Lain yang Sudah Ada Update', 'idUser' => $this->adminUser->id]);
        $courseToUpdate = Course::factory()->create(['nama_course' => 'Nama Kursus Asli Untuk Tes Unik Update', 'idUser' => $this->adminUser->id]);

        $responseConflict = $this->actingAs($this->adminUser)
                                 ->put(route('admin.courses.update', $courseToUpdate), [
                                    'nama_course' => 'Nama Kursus Lain yang Sudah Ada Update'
                                 ]);
        $responseConflict->assertSessionHasErrors('nama_course');

        $responseSameName = $this->actingAs($this->adminUser)
                                 ->put(route('admin.courses.update', $courseToUpdate), [
                                    'nama_course' => 'Nama Kursus Asli Untuk Tes Unik Update'
                                 ]);
        $responseSameName->assertSessionDoesntHaveErrors('nama_course');
        $responseSameName->assertRedirect(route('admin.courses.index'));
    }

    /** @test */
    public function admin_can_view_show_course_page()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);
        // Jika Anda ingin mengetes subCourses:
        // \App\Models\SubCourse::factory()->count(3)->create(['course_id' => $course->id, 'idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.courses.show', $course));

        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.show');
        $response->assertViewHas('course', $course);
        $response->assertViewHas('subCourses');
    }

    /** @test */
    public function admin_can_delete_a_course()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)
                         ->delete(route('admin.courses.destroy', $course));

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success', 'Course berhasil dihapus');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    /** @test */
    public function authenticated_user_can_like_a_course()
    {
        $courseOwner = User::factory()->create();
        $course = Course::factory()->create(['idUser' => $courseOwner->id]);

        $response = $this->actingAs($this->regularUser)
                         ->post(route('admin.courses.like', $course));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Course liked');
        // Ganti 'course_user_likes' dengan nama tabel pivot Anda jika berbeda
        // dan pastikan relasi 'likedCourses' ada di model User.
        $this->assertDatabaseHas('course_user_likes', [
            'user_id' => $this->regularUser->id,
            'course_id' => $course->id,
        ]);
    }

    /** @test */
    public function authenticated_user_can_unlike_a_course()
    {
        $courseOwner = User::factory()->create();
        $course = Course::factory()->create(['idUser' => $courseOwner->id]);

        $this->regularUser->likedCourses()->attach($course->id); // User me-like dulu

        $response = $this->actingAs($this->regularUser)
                         ->post(route('admin.courses.like', $course)); // Aksi 'like' lagi untuk unlike

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Course unliked');
        // Ganti 'course_user_likes' dengan nama tabel pivot Anda jika berbeda
        $this->assertDatabaseMissing('course_user_likes', [
            'user_id' => $this->regularUser->id,
            'course_id' => $course->id,
        ]);
    }

    /** @test */
    public function guest_cannot_access_admin_courses_routes()
    {
        $course = Course::factory()->create();
        $loginRoute = route('login'); // Menggunakan helper route('login') lebih dinamis

        $this->get(route('admin.courses.index'))->assertRedirect($loginRoute);
        $this->get(route('admin.courses.create'))->assertRedirect($loginRoute);
        $this->post(route('admin.courses.store'))->assertRedirect($loginRoute);
        $this->get(route('admin.courses.edit', $course))->assertRedirect($loginRoute);
        $this->put(route('admin.courses.update', $course))->assertRedirect($loginRoute);
        $this->get(route('admin.courses.show', $course))->assertRedirect($loginRoute);
        $this->delete(route('admin.courses.destroy', $course))->assertRedirect($loginRoute);
        $this->post(route('admin.courses.like', $course))->assertRedirect($loginRoute);
    }

    /** @test */
    public function non_admin_user_cannot_access_admin_specific_course_actions()
    {
        $course = Course::factory()->create(['idUser' => $this->adminUser->id]);

        $actions = [
            'index' => fn() => $this->actingAs($this->regularUser)->get(route('admin.courses.index')),
            'create' => fn() => $this->actingAs($this->regularUser)->get(route('admin.courses.create')),
            'store' => fn() => $this->actingAs($this->regularUser)->post(route('admin.courses.store'), []),
            'edit' => fn() => $this->actingAs($this->regularUser)->get(route('admin.courses.edit', $course)),
            'update' => fn() => $this->actingAs($this->regularUser)->put(route('admin.courses.update', $course), []),
            // 'show' bisa jadi boleh diakses user biasa, jika tidak, tambahkan di sini.
            // 'destroy' akan ditest terpisah di bawah karena lebih kritikal.
        ];

        foreach ($actions as $action => $closure) {
            $response = $closure();
            // Sesuaikan assertion berdasarkan perilaku middleware otorisasi admin Anda:
            // $response->assertStatus(403); // Jika Forbidden
            // $response->assertRedirect(route('some.other.page')); // Jika redirect
            $response->assertStatus(302); // Asumsi umum redirect jika tidak diotorisasi
            // Anda mungkin ingin lebih spesifik: $response->assertRedirect(route('login')); atau dashboard user biasa
        }

        // Test khusus untuk 'destroy' oleh non-admin
        $responseDestroy = $this->actingAs($this->regularUser)->delete(route('admin.courses.destroy', $course));
        // $responseDestroy->assertStatus(403); // atau
        $responseDestroy->assertStatus(302);
        $this->assertDatabaseHas('courses', ['id' => $course->id]); // Pastikan data tidak terhapus
    }
}