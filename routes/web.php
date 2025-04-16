<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController;

use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ForumChatController;
use App\Http\Controllers\User\ForumController;


Route::middleware('auth')->group(function () {
    Route::get('/forums', [ForumController::class, 'index'])->name('user.forums.index');
    Route::post('/forums/request/{forumId}', [ForumController::class, 'requestJoin'])->name('user.forums.request');
    
    // Halaman forum yang sudah diterima
    Route::get('/myforums', [ForumController::class, 'myForums'])->name('user.forums.myforums');
    
    // Halaman chat forum
    Route::get('/forums/{forumId}/chat', [ForumChatController::class, 'show'])->name('user.forums.chat.show');
    Route::post('/forums/{forumId}/chat', [ForumChatController::class, 'sendMessage'])->name('user.forums.chat.send');
});


Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');



Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/forum/{forumId}', [UserDashboardController::class, 'index'])->name('forums.chat');
});

Route::get('/user/forums/chat/{forumId}', [UserDashboardController::class, 'chat'])->name('user.forums.chat');
Route::post('/user/forums/sendMessage/{forumId}', [UserDashboardController::class, 'sendMessage'])->name('user.forums.sendMessage');


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
// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::resource('forums', \App\Http\Controllers\Admin\ForumController::class);
    Route::get('forum-requests', [\App\Http\Controllers\Admin\ForumUserRequestController::class, 'index'])->name('forum.requests');
    Route::post('forum-requests/{id}/approve', [\App\Http\Controllers\Admin\ForumUserRequestController::class, 'approve'])->name('forum.requests.approve');
    Route::post('forum-requests/{id}/reject', [\App\Http\Controllers\Admin\ForumUserRequestController::class, 'reject'])->name('forum.requests.reject');
    Route::delete('forums/{forum}/kick/{user}', [\App\Http\Controllers\Admin\ForumUserRequestController::class, 'kick'])->name('forum.kick');
});

// User Routes
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('forums', [\App\Http\Controllers\User\ForumController::class, 'index'])->name('forums.index');
    Route::post('forums/{id}/request', [\App\Http\Controllers\User\ForumController::class, 'requestJoin'])->name('forums.request');

    Route::get('forums/{id}/chat', [\App\Http\Controllers\User\ForumChatController::class, 'show'])->name('forums.chat');
    Route::post('forums/{id}/chat', [\App\Http\Controllers\User\ForumChatController::class, 'sendMessage'])->name('forums.chat.send');
});
// Rute untuk menampilkan daftar forum
Route::get('/forums', [ForumController::class, 'index'])->name('user.forums.index');

// Rute untuk menampilkan halaman chat forum
Route::get('/forums/{forum}/chat', [ForumChatController::class, 'show'])->name('user.forums.chat');

// Rute untuk mengirim pesan di forum
Route::post('/forums/{forum}/chat', [ForumChatController::class, 'sendMessage'])->name('user.forums.chat.send');

// Rute untuk mengirim permintaan bergabung ke forum
Route::post('/forums/{forum}/request', [ForumController::class, 'requestJoin'])->name('user.forums.request');

