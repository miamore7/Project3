@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md border-r hidden md:block">
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
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h2 class="text-3xl font-bold mb-8 text-center text-cyan-700">💬 Forum yang Kamu Ikuti</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($forums as $i => $forum)
                    <div class="bg-white rounded-lg shadow-md border border-gray-100 p-5 flex flex-col justify-between">
                        <div>
                            <h5 class="text-xl font-semibold mb-2 text-gray-800">{{ $forum->name }}</h5>
                            <p class="text-gray-600 mb-4">{{ Str::limit($forum->description, 100) }}</p>
                        </div>
                        <a href="{{ route('user.forums.chat', $forum->id) }}">
                            @if($i % 5 == 0)
                                <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded w-full">💬 Mulai Chat</button>
                            @elseif($i % 5 == 1)
                                <button class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded w-full">💬 Mulai Chat</button>
                            @elseif($i % 5 == 2)
                                <button class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded w-full">💬 Mulai Chat</button>
                            @elseif($i % 5 == 3)
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded w-full">💬 Mulai Chat</button>
                            @else
                                <button class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded w-full">💬 Mulai Chat</button>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
