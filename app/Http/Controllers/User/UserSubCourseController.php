<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubCourse;

class UserSubCourseController extends Controller
{
    public function show(SubCourse $sub_course)
    {
        return view('user.sub-courses.show', compact('sub_course'));
    }
}
