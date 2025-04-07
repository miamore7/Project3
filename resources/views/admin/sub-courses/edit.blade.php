@extends('layouts.app')

@section('content')
<h1>Edit SubCourse</h1>

<form method="POST" action="{{ route('sub-courses.update', $sub_course) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Nama SubCourse:</label><br>
        <input type="text" name="nama_course" value="{{ old('nama_course', $sub_course->nama_course) }}" required>
    </div><br>

    <div>
        <label>Link Video:</label><br>
        <input type="url" name="link_video" value="{{ old('link_video', $sub_course->link_video) }}">
    </div><br>

    <div>
        <label>Deskripsi:</label><br>
        <textarea name="description">{{ old('description', $sub_course->description) }}</textarea>
    </div><br>

    <div>
        <label>Course Induk:</label><br>
        <select name="course_id" required>
            <option value="">-- Pilih Course --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $sub_course->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->nama_course }}
                </option>
            @endforeach
        </select>
    </div><br>

    <button type="submit">Update</button>
</form>
@endsection
