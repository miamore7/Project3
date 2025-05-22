@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-4 shadow">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <!-- Main content -->
    <div class="flex-1 container mx-auto py-8 px-4">
        <!-- Menampilkan notifikasi jika ada session success -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center mb-6">Edit SubCourse</h1>

        <form method="POST" class="max-w-3xl mx-auto p-8 bg-white shadow-lg rounded-lg" action="{{ route('admin.sub-courses.update', $sub_course) }}">
            @csrf
            @method('PUT')

            <!-- Nama SubCourse Input -->
            <div class="mb-6">
                <label for="nama_course" class="block text-sm font-semibold text-gray-700">Nama SubCourse</label>
                <input 
                    type="text" 
                    name="nama_course" 
                    id="nama_course" 
                    class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    value="{{ old('nama_course', $sub_course->nama_course) }}" 
                    required
                >
            </div>

            <!-- Link Video Input -->
            <div class="mb-6">
                <label for="link_video" class="block text-sm font-semibold text-gray-700">Link Video</label>
                <input 
                    type="url" 
                    name="link_video" 
                    id="link_video" 
                    class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    value="{{ old('link_video', $sub_course->link_video) }}"
                >
            </div>

            <!-- Deskripsi Input -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    rows="4">{{ old('description', $sub_course->description) }}</textarea>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="w-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
