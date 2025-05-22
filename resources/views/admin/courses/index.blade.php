@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-4 shadow min-h-screen">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-8">
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6">Daftar Course</h1>

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.courses.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition" style="text-decoration: none;">
                + Tambah Course
            </a>
        </div>

        <div class="space-y-8 w-full">
            @foreach ($courses as $course)
                <div class="bg-white shadow rounded p-6">
                    <h2 class="text-xl font-semibold">{{ $course->nama_course }}</h2>
                    <p class="text-sm text-gray-600 mb-2">Oleh: {{ $course->user->name }}</p>

                    <div class="flex gap-4 mb-4">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:underline">Edit</a>
                        <a href="{{ route('admin.courses.show', $course) }}" class="text-green-600 hover:underline">Detail</a>
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                        </form>
                    </div>

                    @if ($course->subCourses->count())
                        <div class="ml-4 space-y-4">
                            @foreach ($course->subCourses as $sub)
                                <div class="border rounded p-4">
                                    <h3 class="font-semibold">🧩 {{ $sub->nama_course }}</h3>
                                    <p class="text-sm text-gray-500">Oleh: {{ $sub->user->name ?? '-' }}</p>

                                    @php
                                        function getYoutubeEmbedUrl($url) {
                                            if (preg_match('/youtu\.be\/([^\?]*)/', $url, $matches)) {
                                                return 'https://www.youtube.com/embed/' . $matches[1];
                                            } elseif (preg_match('/youtube\.com.*v=([^&]*)/', $url, $matches)) {
                                                return 'https://www.youtube.com/embed/' . $matches[1];
                                            }
                                            return null;
                                        }
                                        $embedUrl = getYoutubeEmbedUrl($sub->link_video);
                                    @endphp

                                    @if ($embedUrl)
                                        <iframe class="responsive-video my-2 rounded" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                                    @else
                                        <p class="text-sm text-red-500">Link video tidak valid.</p>
                                    @endif

                                    <div class="flex gap-3 mt-2">
                                        <a href="{{ route('sub-courses.edit', $sub) }}" class="text-blue-600 hover:underline">Edit SubCourse</a>
                                        <form method="POST" action="{{ route('sub-courses.destroy', $sub) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mt-2 ml-4">Belum ada SubCourse.</p>
                    @endif
                </div>
            @endforeach
        </div>

        <style>
            .responsive-video {
                width: 100%;
                max-width: 800px;
                aspect-ratio: 16/9;
                margin: 0 auto;
            }
        </style>
    </main>
</div>
@endsection
