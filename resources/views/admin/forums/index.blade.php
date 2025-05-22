@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-4 shadow min-h-screen">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-6">Daftar Forum</h2>

        <a href="{{ route('admin.forums.create') }}"
           class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
            + Buat Forum
        </a>

        <!-- Forums List as Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($forums as $forum)
            <div class="border rounded-lg shadow p-4 flex flex-col justify-between">
                <div>
                    <h5 class="text-xl font-semibold">{{ $forum->name }}</h5>
                    <p class="text-gray-700">Anggota: {{ $forum->members->count() }}</p>
                </div>

                <form action="{{ route('admin.forums.destroy', $forum) }}" method="POST" class="mt-4">
                    @csrf @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Hapus forum?')"
                            class="text-red-600 hover:underline">
                        Hapus
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </main>
</div>
@endsection
