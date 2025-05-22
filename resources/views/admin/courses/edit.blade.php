@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-4 shadow min-h-screen">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <!-- Konten utama -->
    <main class="flex-1 p-8">
        <!-- Notifikasi sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6">Edit Course</h1>

        <form method="POST" class="card p-4 bg-white rounded shadow" action="{{ route('admin.courses.update', $course) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_course" class="text-sm font-semibold block">Nama Course</label>
                <input type="text" name="nama_course" class="rounded w-full border p-2"
                       value="{{ old('nama_course', $course->nama_course) }}" required>
            </div>

            <div class="mb-4">
                <label for="link_video" class="text-sm font-semibold block">Link Video</label>
                <input type="url" name="link_video" class="rounded w-full border p-2"
                       value="{{ old('link_video', $course->link_video) }}">
            </div>

            <div class="mb-4">
                <label for="description" class="text-sm font-semibold block">Deskripsi</label>
                <textarea name="description" rows="4" class="rounded w-full border p-2">{{ old('description', $course->description) }}</textarea>
            </div>

            <button type="submit"
                class="bg-red-400 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </form>
    </main>
</div>
@endsection
