<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;

class UserDashboardController extends Controller
{
    public function index()
    {
        $courses = Course::with('user')->get(); // ambil semua course dengan relasi user
        return view('user.dashboard', compact('courses'));
    }
}
