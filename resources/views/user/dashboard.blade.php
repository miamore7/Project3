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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 p-6">
        <h1 class="text-3xl font-bold mb-8 text-center">Dashboard User</h1>

        <!-- Forum Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <h2 class="text-xl font-semibold mb-3">Forum yang Kamu Ikuti</h2>
                <a href="{{ route('user.forums.myforums') }}"
                   class="bg-cyan-500 text-white px-6 py-2 rounded hover:bg-cyan-600 transition">Lihat Forum</a>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <h2 class="text-xl font-semibold mb-3">Daftar Forum</h2>
                <a href="{{ route('user.forums.index') }}"
                   class="bg-cyan-500 text-white px-6 py-2 rounded hover:bg-cyan-600 transition">Lihat List Forum</a>
            </div>
        </div>

        <!-- Top Courses -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
                Top Courses <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded">Best Sellers</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($courses as $c)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="{{ asset('images/Gitar.jpeg') }}" alt="Course Image" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">{{ $c->nama_course }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($c->description, 100) }}</p>
                        <p class="text-sm text-gray-500 mb-3">Oleh: {{ $c->user->name ?? 'Tidak diketahui' }}</p>
                        <a href="{{ route('user.courses.show', $c) }}" class="text-green-600 hover:underline text-sm no-underline">Lihat Detail</a>
                    </div>
                    <div class="bg-gray-100 text-right p-3 text-xs text-gray-500">
                        {{ $c->created_at->format('d M Y') }}
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- More Courses -->
        <section class="text-center">
            <h2 class="text-2xl font-semibold mb-4">
                More Courses <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded">Best Coaches</span>
            </h2>
            <button id="toggleCoursesBtn" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition mb-6">
                Tampilkan / Sembunyikan
            </button>
            <div id="coursesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 hidden">
                @foreach($courses as $course)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="{{ asset('images/Gitar.jpeg') }}" alt="Course Image" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">{{ $course->nama_course }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($course->description, 100) }}</p>
                        <p class="text-sm text-gray-500 mb-3">Oleh: {{ $course->user->name ?? 'Tidak diketahui' }}</p>
                        <a href="{{ route('user.courses.show', $course) }}" class="text-green-600 hover:underline text-sm">Lihat Detail</a>
                    </div>
                    <div class="bg-gray-100 text-right p-3 text-xs text-gray-500">
                        {{ $course->created_at->format('d M Y') }}
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('toggleCoursesBtn').addEventListener('click', function () {
        document.getElementById('coursesContainer').classList.toggle('hidden');
    });
</script>
@endsection
