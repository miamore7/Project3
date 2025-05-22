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

        <h1 class="text-3xl font-bold mb-2">{{ $course->nama_course }}</h1>
        <p class="text-gray-600 mb-4">Dibuat oleh: {{ $course->user->name ?? 'Tidak diketahui' }}</p>
        
        @php
            function getYoutubeEmbedUrl($url)
            {
                if (preg_match('/youtu\.be\/([^\?]*)/', $url, $matches)) {
                    return 'https://www.youtube.com/embed/' . $matches[1];
                } elseif (preg_match('/youtube\.com.*v=([^&]*)/', $url, $matches)) {
                    return 'https://www.youtube.com/embed/' . $matches[1];
                }
                return null;
            }
            $embedUrl = getYoutubeEmbedUrl($course->link_video);
        @endphp

        @if ($embedUrl)
            <div class="mb-6">
                <iframe class="responsive-video w-full rounded shadow" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @else
            <p class="text-red-500">Link video tidak valid.</p>
        @endif

        <p class="mb-8 text-gray-700">{{ $course->description }}</p>

        @if(Auth::user()->role == 'admin')
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Sub Courses</h2>
            <a href="{{ route('admin.sub-courses.create', ['course_id' => $course->id]) }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                + Tambah SubCourse
            </a>
        </div>
        @endif

        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($subCourses as $sub)
            <div class="bg-white shadow p-4 rounded-lg">
                <h3 class="text-lg font-bold mb-1">{{ $sub->nama_course }}</h3>
                <p class="text-sm text-gray-600 mb-2">Oleh: {{ $sub->user->name ?? '-' }}</p>

                @php
                    $subEmbed = getYoutubeEmbedUrl($sub->link_video);
                @endphp

                @if ($subEmbed)
                <iframe class="responsive-video w-full rounded mb-3" src="{{ $subEmbed }}" frameborder="0" allowfullscreen></iframe>
                @else
                <p class="text-red-400 text-sm">Link video tidak valid.</p>
                @endif

                @if(Auth::user()->role == 'admin')
                <div class="flex gap-3">
                    <a href="{{ route('admin.sub-courses.edit', $sub) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.sub-courses.destroy', $sub) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
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
