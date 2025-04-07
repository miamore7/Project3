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
        $request->validate([
            'nama_course' => 'required|string|max:255',
            'link_video' => 'nullable|url',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
        ]);

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
        $request->validate([
            'nama_course' => 'required|string|max:255',
            'link_video' => 'nullable|url',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
        ]);

        $sub_course->update([
            'nama_course' => $request->nama_course,
            'link_video' => $request->link_video,
            'description' => $request->description,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('sub-courses.index')->with('success', 'SubCourse berhasil diupdate');
    }

    public function destroy(SubCourse $sub_course)
    {
        $sub_course->delete();
        return redirect()->route('sub-courses.index')->with('success', 'SubCourse berhasil dihapus');
    }
}
