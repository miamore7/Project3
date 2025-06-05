{{-- resources/views/admin/courses/show.blade.php (atau path yang sesuai) --}}
@extends('layouts.app')

@section('content')
<div class="flex">
    <aside class="w-64 bg-white p-4 shadow min-h-screen">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <main class="flex-1 p-8">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-2">{{ $course->nama_course }}</h1>
        <p class="text-gray-600 mb-4">Dibuat oleh: {{ $course->user->name ?? 'Tidak diketahui' }}</p>

        {{-- HAPUS DEFINISI FUNGSI DARI SINI --}}
        @php
            // Sekarang fungsi getYoutubeEmbedUrl() sudah global,
            // jadi kita bisa langsung memanggilnya.
            $embedUrl = getYoutubeEmbedUrl($course->link_video);
        @endphp

        @if ($embedUrl)
            <div class="mb-6">
                <iframe class="responsive-video w-full rounded shadow" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @else
            @if($course->link_video) {{-- Hanya tampilkan error jika link_video ada tapi tidak valid --}}
                <p class="text-red-500">Link video tidak valid atau tidak dapat di-embed.</p>
            @endif
        @endif

        <p class="mb-8 text-gray-700">{{ $course->description }}</p>

        @if(Auth::check() && Auth::user()->role == 'admin') {{-- Selalu baik untuk mengecek Auth::check() dulu --}}
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
                    @if($sub->link_video)
                        <p class="text-red-400 text-sm">Link video tidak valid atau tidak dapat di-embed.</p>
                    @endif
                @endif

                @if(Auth::check() && Auth::user()->role == 'admin')
                <div class="flex gap-3">
                    <a href="{{ route('admin.sub-courses.edit', $sub) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.sub-courses.destroy', $sub) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sub course ini?');">
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
                max-width: 800px; /* Atau sesuai preferensi Anda */
                aspect-ratio: 16/9;
                margin: 0 auto;
            }
        </style>
    </main>
</div>
@endsection