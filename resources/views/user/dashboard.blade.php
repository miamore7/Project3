@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6" style="text-align:center">Dashboard User</h1>

    <!-- <div class="flex justify-center mb-6">
        <button id="toggleCoursesBtn" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700 transition">
            📚 Lihat Course
        </button>
    </div> -->


    <h1>Top Courses <span class="badge text-bg-secondary">Best Sellers</span></h1>
    <div class="card-group">
        @foreach ($courses as $c)
        <div class="card">
            <img src="{{ asset('images/Gitar.jpeg') }}" class="card-img-top" alt="..." style="max-height: 300px;">
            <div class="card-body">
                <h5 class="card-title">{{ $c->nama_course }}</h5>
                <p class="card-text">Penjelasan Template {{ Str::limit($c->description, 100) }}, Oleh: {{ $c->user->name ?? 'Tidak diketahui' }}</p>
                <a href="{{ route('courses.show', $c) }}" class="text-green-600 hover:underline">Lihat Detail</a>

            </div>
            <div class="card-footer">
                <small class="text-body-secondary">{{ $c->created_at }}</small>
            </div>
        </div>
        @endforeach
    </div>
    <hr>
    <h2 style="text-align:center">More Courses <span class="badge text-bg-secondary">Best Coaches</span></h2>
    <div id="coursesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
        @foreach($courses as $course)
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-xl font-semibold">{{ $course->nama_course }}</h2>
            <p class="text-gray-600 text-sm mb-2">Oleh: {{ $course->user->name ?? 'Tidak diketahui' }}</p>
            <p class="text-gray-700 mb-4">{{ Str::limit($course->description, 100) }}</p>
            <a href="{{ route('courses.show', $course) }}" class="text-green-600 hover:underline">Lihat Detail</a>
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