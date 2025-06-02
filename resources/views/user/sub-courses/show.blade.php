@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white shadow-md border-r md:block hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-6 text-cyan-600">Menu</h2>
            <ul class="space-y-4">
                <li><a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-cyan-600">🏠 Dashboard</a></li>
                <li><a href="{{ route('user.forums.myforums') }}" class="text-gray-700 hover:text-cyan-600">💬 Forum Saya</a></li>
                <li><a href="{{ route('user.forums.index') }}" class="text-gray-700 hover:text-cyan-600">📚 Daftar Forum</a></li>
                <li><a href="{{ route('user.courses.index') }}" class="text-gray-700 hover:text-cyan-600">🎓 Daftar Course</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $sub_course->nama_course }}</h1>

            @if($sub_course->link_video)
                <div class="mb-4">
                    <iframe class="w-full rounded shadow" height="400" src="{{ $sub_course->link_video }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif

            <p class="text-gray-600 mb-6">{{ $sub_course->description }}</p>

            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                ← Kembali
            </a>
        </div>
    </main>
</div>
@endsection
