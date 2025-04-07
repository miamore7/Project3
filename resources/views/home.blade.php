@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    @if (session('status'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <p class="mb-6">Selamat datang! Berikut adalah kursus yang tersedia:</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($courses as $course)
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-xl font-semibold">{{ $course->nama_course }}</h2>
            <p class="text-sm text-gray-600 mb-2">oleh {{ $course->user->name ?? 'Tidak diketahui' }}</p>
            <p class="text-sm text-gray-700 mb-3">{{ Str::limit($course->description, 80) }}</p>

            @php
                function getYoutubeEmbedUrl($url) {
                    if (preg_match('/youtu\.be\/([^\?]*)/', $url, $matches)) {
                        return 'https://www.youtube.com/embed/' . $matches[1];
                    } elseif (preg_match('/youtube\.com.*v=([^&]*)/', $url, $matches)) {
                        return 'https://www.youtube.com/embed/' . $matches[1];
                    }
                    return null;
                }
                $embedUrl = getYoutubeEmbedUrl($course->link_video);
            @endphp

            @if($embedUrl)
                <iframe class="w-full h-40 rounded" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
            @endif

            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:underline">Lihat Detail</a>

                {{-- Contoh tombol "Like" (implementasi backend dibutuhkan) --}}
                <form action="{{ route('courses.like', $course->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">❤️ Like</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
