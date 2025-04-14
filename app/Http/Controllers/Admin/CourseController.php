<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['user', 'subCourses'])->get();
    
        return view('admin.courses.index', compact('courses'));
    }
    

    public function create() {
        return view('admin.courses.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_course' => 'required|string|max:255',
        'link_video' => 'nullable|url',
        'description' => 'nullable|string',
    ]);

    Course::create([
        'nama_course' => $request->nama_course,
        'link_video' => $request->link_video,
        'description' => $request->description,
        'idUser' => auth()->id(),
    ]);

    return redirect()->route('courses.index')->with('success', 'Course berhasil ditambahkan');
}


    public function edit(Course $course) {
        return view('admin.courses.edit', compact('course'));
    }

    public function show(Course $course)
{
    $subCourses = $course->subCourses()->with('user')->get();
    return view('admin.courses.show', compact('course', 'subCourses'));
}

    public function update(Request $request, Course $course) {
        $request->validate([
            'nama_course' => 'required|string|max:255',
        ]);

        $course->update($request->only('nama_course', 'link_video', 'description'));

        return redirect()->route('courses.index')->with('success', 'Course berhasil diperbarui');
    }

    public function destroy(Course $course) {
        $course->delete();
        return back()->with('success', 'Course berhasil dihapus');
    }

    public function like(Course $course)
{
    $user = auth()->user();
    if ($user->likedCourses()->where('course_id', $course->id)->exists()) {
        // Jika sudah like, maka un-like
        $user->likedCourses()->detach($course->id);
    } else {
        $user->likedCourses()->attach($course->id);
    }

    return back();
}

}
