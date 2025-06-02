@extends('layouts.app') {{-- Pastikan layout ini mendukung grid atau flex --}}

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md border-r hidden md:block h-screen sticky top-0">
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
        <div class="container mt-4">
            <h2 class="text-2xl font-semibold mb-4">Daftar Course</h2>
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->nama_course }}</h5>
                                <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                <a href="{{ route('user.courses.show', $course->id) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
