@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Edit Course</h1>
        <form method="POST" class="card p-4 " action="{{ route('courses.update', $course) }}">
            @csrf
            @method('PUT')
            <label for="nama_course" class="text-sm font-semibold">Nama Course</label>
            <input type="text" name="nama_course" class="rounded" value="{{ old('nama_course', $course->nama_course) }}"
                required>

            <br>
            <label for="link_video" class="text-sm font-semibold">Link Video</label>
            <input type="url" name="link_video" class="rounded" value="{{ old('link_video', $course->link_video) }}">

            <br>
            <label for="Deskripsi" class="text-sm font-semibold">Deskripsi</label>
            <textarea name="description" class="rounded">{{ old('description', $course->description) }}</textarea><br>

            <button type="submit"
                class="bg-red-400 hover:bg-blue-700 dark:text-white font-bold py-2 px-4 rounded">Simpan</button>
        </form>
    </div>
@endsection
