<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('user')->latest()->get();
        return view('user.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $subCourses = $course->subCourses()->with('user')->get();
        return view('user.courses.show', compact('course', 'subCourses'));
    }
}
