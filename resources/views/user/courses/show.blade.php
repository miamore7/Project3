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
            <h2 class="text-3xl font-bold mb-4 text-gray-800">{{ $course->nama_course }}</h2>
            <p class="text-gray-600 mb-6">{{ $course->description }}</p>

            @if($course->link_video)
                <div class="mb-6">
                    <iframe class="w-full rounded shadow" height="400" src="{{ $course->link_video }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif

            <div class="mb-6">
                <h4 class="text-xl font-semibold mb-3 text-cyan-700">📂 Sub-Course</h4>
                @if($subCourses->count())
                    <div class="space-y-4">
                        @foreach($subCourses as $sub)
                            <div class="border p-4 rounded shadow-sm bg-gray-50">
                              <a href="{{ route('user.sub-courses.show', $sub->id) }}" class="block">
    <h5 class="font-bold text-gray-800 hover:text-cyan-700">{{ $sub->nama_course }}</h5>
</a>
<p class="text-gray-600">{{ $sub->description }}</p>

                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Belum ada sub-course.</p>
                @endif
            </div>

            <a href="{{ route('user.courses.index') }}" class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                ← Kembali ke Daftar Course
            </a>
        </div>
    </main>
</div>
@endsection
