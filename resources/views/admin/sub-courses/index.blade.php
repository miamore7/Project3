@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-4 shadow h-screen sticky top-0">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <!-- Main content -->
    <main class="flex-1 container mx-auto py-8 px-6">
        <!-- Notifikasi session sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Judul Halaman -->
        <h1 class="text-3xl font-bold mb-6">Daftar SubCourse</h1>

        <!-- Tombol Tambah SubCourse -->
        <a href="{{ route('admin.sub-courses.create') }}" 
           class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition mb-6 no-underline">
            + Tambah SubCourse
        </a>

        <!-- Flash Message untuk Error -->
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-6 shadow">
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        @endif

        <!-- List SubCourses -->
        <ul class="space-y-4">
            @forelse($subCourses as $sub)
                <li class="p-4 bg-white rounded shadow">
                    <h2 class="text-lg font-semibold">{{ $sub->nama_sub_course ?? '-' }}</h2>
                    <p class="text-sm text-gray-600">
                        Kursus Induk: <strong>{{ $sub->course->nama_course ?? '-' }}</strong>
                    </p>
                    <p class="text-sm text-gray-600">
                        Oleh: {{ $sub->user->name ?? '-' }}
                    </p>

                    <div class="mt-3 flex space-x-4">
                        <a href="{{ route('admin.sub-courses.edit', $sub) }}" class="text-blue-600 hover:underline no-underline">
                            ✏️ Edit
                        </a>

                        <form method="POST" action="{{ route('admin.sub-courses.destroy', $sub) }}" onsubmit="return confirm('Yakin ingin menghapus sub-course ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="p-4 bg-white rounded shadow text-center text-gray-500">
                    Belum ada data sub-course.
                </li>
            @endforelse
        </ul>
    </main>
</div>
@endsection
