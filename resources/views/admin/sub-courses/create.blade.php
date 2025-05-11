@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-2xl shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Tambah SubCourse</h1>

    <form method="POST" action="{{ route('sub-courses.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="nama_course" class="block text-sm font-medium text-gray-700">Nama SubCourse</label>
            <input type="text" id="nama_course" name="nama_course" placeholder="Nama SubCourse" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="link_video" class="block text-sm font-medium text-gray-700">Link Video</label>
            <input type="url" id="link_video" name="link_video" placeholder="https://..."
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="description" name="description" rows="4" placeholder="Deskripsi"
                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div>
            <label for="course_id" class="block text-sm font-medium text-gray-700">Course Induk</label>
            <select id="course_id" name="course_id" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih Course Induk --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->nama_course }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
