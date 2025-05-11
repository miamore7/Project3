<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCourse;
use App\Models\Course;
use Illuminate\Http\Request;

class SubCourseController extends Controller
{
    public function index()
    {
        $subCourses = SubCourse::with(['course', 'user'])->get();
        return view('admin.sub-courses.index', compact('subCourses'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.sub-courses.create', compact('courses'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_course' => 'required|string|max:255|unique:sub_courses,nama_course', // Validasi nama unik
            'link_video' => 'nullable|url',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
        ], [
            'nama_course.unique' => 'Nama SubCourse ini sudah terdaftar. Harap pilih nama lain.'
        ]);

        // Membuat SubCourse baru
        SubCourse::create([
            'nama_course' => $request->nama_course,
            'link_video' => $request->link_video,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'idUser' => auth()->id(),
        ]);

        return redirect()->route('sub-courses.index')->with('success', 'SubCourse berhasil ditambahkan');
    }

    public function edit(SubCourse $sub_course)
    {
        $courses = Course::all();
        return view('admin.sub-courses.edit', compact('sub_course', 'courses'));
    }

    public function update(Request $request, SubCourse $sub_course)
    {
        // Validasi input
        $request->validate([
            'nama_course' => 'required|string|max:255',
            'link_video' => 'nullable|url',
            'description' => 'nullable|string',
        ]);
    
        // Update data sub-course
        $sub_course->update([
            'nama_course' => $request->nama_course,
            'link_video' => $request->link_video,
            'description' => $request->description,
        ]);
    
        // Redirect ke index dengan flash message
        return redirect()->route('sub-courses.index')->with('success', 'SubCourse berhasil diperbarui');
    }
    
    public function destroy(SubCourse $sub_course)
    {
        // Menghapus SubCourse
        $sub_course->delete();
    
        // Menambahkan flash message dan mengarahkan ke halaman sub-courses.index
        return redirect()->route('sub-courses.index')->with('success', 'SubCourse berhasil dihapus');
    }
    
}
