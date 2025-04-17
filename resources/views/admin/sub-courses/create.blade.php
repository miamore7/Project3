@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm">
        <h1 class="text-2xl font-semibold mb-6">Tambah SubCourse</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sub-courses.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nama_course" class="block text-sm font-medium text-gray-700 mb-1">Nama SubCourse</label>
                <input type="text" name="nama_course" id="nama_course"
                       class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="link_video" class="block text-sm font-medium text-gray-700 mb-1">Link Video</label>
                <input type="url" name="link_video" id="link_video"
                       class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Course Induk</label>
                <select name="course_id" id="course_id" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Course Induk --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->nama_course }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('sub-courses.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded mr-2" style="text-decoration: none;">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
