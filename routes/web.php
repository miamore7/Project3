<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController;

use App\Http\Controllers\User\UserDashboardController;





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('sub-courses', App\Http\Controllers\Admin\SubCourseController::class);
});


    // Middleware untuk Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    // Middleware untuk User
    Route::middleware(['user'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');
    });



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('sub-courses', App\Http\Controllers\Admin\SubCourseController::class);
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('sub-courses', App\Http\Controllers\Admin\SubCourseController::class);
});
Route::get('/admin/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::post('/courses/{course}/like', [CourseController::class, 'like'])->name('courses.like');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});
