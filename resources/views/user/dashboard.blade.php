@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Dashboard User</h1>

    <!-- Flexbox Layout for Forum Button and Courses -->
    <div class="flex justify-between mb-8">
        <!-- Forum Button -->
        <div class="w-full md:w-1/3 p-4">
            <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
            <div>
                <a href="{{ route('user.forums.myforums') }}" class="btn btn-info text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition w-full">Lihat Forum yang Kamu Ikuti</a>
            </div>
        </div>

        <!-- Top Courses Section -->
        <div class="w-full md:w-2/3 p-4">
            <h1 class="text-xl font-semibold mb-4">Top Courses <span class="badge text-bg-secondary">Best Sellers</span></h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($courses as $c)
                <div class="card border rounded-lg shadow-lg">
                    <img src="{{ asset('images/Gitar.jpeg') }}" class="card-img-top rounded-t-lg" alt="Course Image" style="max-height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="card-title text-xl font-semibold">{{ $c->nama_course }}</h5>
                        <p class="card-text text-gray-700 text-sm mb-4">Penjelasan Template {{ Str::limit($c->description, 100) }}, Oleh: {{ $c->user->name ?? 'Tidak diketahui' }}</p>
                        <a href="{{ route('courses.show', $c) }}" class="text-green-600 hover:underline">Lihat Detail</a>
                    </div>
                    <div class="card-footer text-right p-4">
                        <small class="text-gray-500">{{ $c->created_at->format('d M Y') }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <hr class="my-8">

    <!-- More Courses Section -->
    <h2 class="text-xl font-semibold mb-4 text-center">More Courses <span class="badge text-bg-secondary">Best Coaches</span></h2>
    <div id="coursesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 hidden">
        @foreach($courses as $course)
        <div class="card border rounded-lg shadow-lg">
            <img src="{{ asset('images/Gitar.jpeg') }}" class="card-img-top rounded-t-lg" alt="Course Image" style="max-height: 200px; object-fit: cover;">
            <div class="card-body p-4">
                <h5 class="card-title text-xl font-semibold">{{ $course->nama_course }}</h5>
                <p class="text-gray-600 text-sm mb-4">Oleh: {{ $course->user->name ?? 'Tidak diketahui' }}</p>
                <p class="text-gray-700 mb-4">{{ Str::limit($course->description, 100) }}</p>
                <a href="{{ route('courses.show', $course) }}" class="text-green-600 hover:underline">Lihat Detail</a>
            </div>
            <div class="card-footer text-right p-4">
                <small class="text-gray-500">{{ $course->created_at->format('d M Y') }}</small>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('toggleCoursesBtn').addEventListener('click', function() {
        const container = document.getElementById('coursesContainer');
        container.classList.toggle('hidden');
    });
</script>
@endsection
