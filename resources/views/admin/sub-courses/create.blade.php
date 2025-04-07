@extends('layouts.app')

@section('content')
<h1>Tambah SubCourse</h1>
<form method="POST" action="{{ route('sub-courses.store') }}">
    @csrf
    <select name="course_id" required>
        <option value="">-- Pilih Course --</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->nama_course }}</option>
        @endforeach
    </select><br>

    <input type="text" name="nama_course" placeholder="Nama SubCourse" required><br>
    <input type="url" name="link_video" placeholder="Link Video"><br>
    <textarea name="description" placeholder="Deskripsi"></textarea><br>
    <button type="submit">Simpan</button>
</form>
@endsection
