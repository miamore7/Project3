@extends('layouts.app')

@section('content')


    <form method="POST" action="{{ route('courses.update', $course) }}">
        @csrf
        @method('PUT')

        <input type="text" name="nama_course" value="{{ old('nama_course', $course->nama_course) }}" required><br>
        <input type="url" name="link_video" value="{{ old('link_video', $course->link_video) }}"><br>
        <textarea name="description">{{ old('description', $course->description) }}</textarea><br>

        <button type="submit">Simpan</button>
    </form>
@endsection
