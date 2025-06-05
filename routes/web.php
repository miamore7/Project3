<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ForumUserRequestController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ForumController as UserForumController;
use App\Http\Controllers\User\ForumChatController as UserForumChatController;
use App\Http\Controllers\Admin\ForumController as AdminForumController;
use App\Http\Controllers\User\CourseController as UserCourseController;
use App\Http\Controllers\Admin\SubCourseController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\User\UserSubCourseController;

Route::get('/sub-courses/{sub_course}', [UserSubCourseController::class, 'show'])->name('user.sub-courses.show');

// Jika ingin tanpa prefix admin:
Route::get('/sub-courses', [SubCourseController::class, 'index'])->name('sub-courses.index');
Route::get('/sub-courses/create', [SubCourseController::class, 'create'])->name('sub-courses.create');
Route::post('/sub-courses', [SubCourseController::class, 'store'])->name('sub-courses.store');
Route::get('/sub-courses/{sub_course}/edit', [SubCourseController::class, 'edit'])->name('sub-courses.edit');
Route::put('/sub-courses/{sub_course}', [SubCourseController::class, 'update'])->name('sub-courses.update');
Route::delete('/sub-courses/{sub_course}', [SubCourseController::class, 'destroy'])->name('sub-courses.destroy');

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/courses', [UserCourseController::class, 'index'])->name('user.courses.index');
    Route::get('/courses/{course}', [UserCourseController::class, 'show'])->name('user.courses.show');
    Route::post('/courses/{course}/like', [UserCourseController::class, 'like'])->name('user.courses.like');
});

Route::get('/', fn() => view('welcome'));

// Auth Routes
Auth::routes();

// Profile (All Authenticated Users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::middleware(['auth', 'admin'])->get('/profile/{user}/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.reset-password');
});


// =============================
// Admin Routes
// =============================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');

    // Reset Password
    Route::post('/users/{id}/reset-password-default', [UserManagementController::class, 'resetPasswordToDefault'])->name('users.reset-password-default');

    // Forum Management
    Route::resource('forums', AdminForumController::class);
    Route::get('forum-requests', [ForumUserRequestController::class, 'index'])->name('forum.requests');
    Route::post('forum-requests/{id}/approve', [ForumUserRequestController::class, 'approve'])->name('forum.requests.approve');
    Route::post('forum-requests/{id}/reject', [ForumUserRequestController::class, 'reject'])->name('forum.requests.reject');
    Route::delete('forums/{forum}/kick/{user}', [ForumUserRequestController::class, 'kick'])->name('forum.kick');

    // Courses
    Route::get('courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index');

    Route::resource('courses', CourseController::class);
    Route::resource('sub-courses', \App\Http\Controllers\Admin\SubCourseController::class);
    Route::post('/courses/{course}/like', [CourseController::class, 'like'])->name('courses.like');
});

// =============================
// User Routes
// =============================
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Forum
    Route::get('forums', [UserForumController::class, 'index'])->name('forums.index');
    Route::post('forums/{id}/request', [UserForumController::class, 'requestJoin'])->name('forums.request');
    Route::get('forums/my', [UserForumController::class, 'myForums'])->name('forums.myforums');


    // Chat
    Route::get('forums/{forum}/chat', [UserForumChatController::class, 'show'])->name('forums.chat');
    Route::post('forums/{forum}/chat', [UserForumChatController::class, 'sendMessage'])->name('forums.chat.send');
});
