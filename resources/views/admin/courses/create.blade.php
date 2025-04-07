@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Tambah Course</h1>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf

        <div class="mb-4">
            <label for="nama_course" class="block font-semibold mb-1">Nama Course</label>
            <input type="text" name="nama_course" id="nama_course" class="w-full border rounded px-3 py-2" required value="{{ old('nama_course') }}">
        </div>

        <div class="mb-4">
            <label for="link_video" class="block font-semibold mb-1">Link Video</label>
            <input type="url" name="link_video" id="link_video" class="w-full border rounded px-3 py-2" value="{{ old('link_video') }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('courses.index') }}" class="px-4 py-2 mr-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
