@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md border-r hidden md:block h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-6 text-cyan-600">Menu</h2>
            <ul class="space-y-4">
                <li><a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-cyan-600 no-underline">🏠 Dashboard</a></li>
                <li><a href="{{ route('user.forums.myforums') }}" class="text-gray-700 hover:text-cyan-600 no-underline">💬 Forum Saya</a></li>
                <li><a href="{{ route('user.forums.index') }}" class="text-gray-700 hover:text-cyan-600 no-underline">📚 Daftar Forum</a></li>
                <li><a href="{{ route('user.courses.index') }}" class="text-gray-700 hover:text-cyan-600 no-underline">🎓 Daftar Course</a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <h2 class="text-2xl font-bold mb-6 text-cyan-700">📚 Forum yang Tersedia</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($forums as $forum)
                    <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">{{ $forum->name }}</h3>

                        @if(in_array($forum->id, $joinedForums))
                            <button class="bg-green-600 text-white px-4 py-2 rounded w-full cursor-not-allowed" disabled>
                                ✅ Sudah Bergabung
                            </button>
                        @elseif(in_array($forum->id, $requestedForums))
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded w-full cursor-not-allowed" disabled>
                                ⏳ Menunggu Persetujuan
                            </button>
                        @else
                            <form action="{{ route('user.forums.request', $forum->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full hover:bg-blue-700 transition">
                                    ➕ Request Join
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
