<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\SubCourse;

class DashboardController extends Controller
{
    public function index()
{
    // Hitung jumlah user aktif (pastikan kolom "status" ada di tabel users)
    $jumlahUserAktif = User::where('status', 'aktif')->count();

    // Hitung semua course
    $jumlahCourse = Course::count();

    // Hitung semua sub-course
    $jumlahSubCourse = SubCourse::count();

    // Ambil data terbaru untuk ditampilkan jika diperlukan (opsional)
    $latestCourses = Course::with('user')->latest()->take(5)->get();
    $latestSubCourses = SubCourse::with('user', 'course')->latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'jumlahUserAktif',
        'jumlahCourse',
        'jumlahSubCourse',
        'latestCourses',
        'latestSubCourses'
    ));
}

}
