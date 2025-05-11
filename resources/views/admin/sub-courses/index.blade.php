@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Daftar SubCourse</h1>

    <!-- Flash Message for Success -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <!-- Flash Message for Error -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <strong>Gagal!</strong> {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('sub-courses.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition" style="text-decoration: none;">
        + Tambah SubCourse
    </a>

    <ul class="space-y-4 mt-4">
        @foreach($subCourses as $sub)
            <li class="p-4 bg-white rounded shadow">
                <h2 class="text-lg font-semibold">{{ $sub->nama_course }}</h2>
                <p class="text-sm text-gray-600">Kursus Induk: <strong>{{ $sub->course->nama_course ?? '-' }}</strong></p>
                <p class="text-sm text-gray-600">Oleh: {{ $sub->user->name ?? '-' }}</p>

                <div class="mt-2 flex space-x-2">
                    <a href="{{ route('sub-courses.edit', $sub) }}" class="text-blue-600 hover:underline">✏️ Edit</a>

                    <form method="POST" action="{{ route('sub-courses.destroy', $sub) }}" onsubmit="return confirm('Yakin ingin menghapus sub-course ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">🗑️ Hapus</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
