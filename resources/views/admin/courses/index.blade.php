@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4 fw-bold">Daftar Course</h1>

    {{-- Box putih dengan tombol biru --}}
    <div class="card mb-4">
        <div class="card-body">
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                + Tambah Course
            </a>
        </div>
    </div>

    {{-- List Course --}}
    <div class="row gy-4">
        @foreach($courses as $course)
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->nama_course }}</h5>
                    <p class="card-subtitle mb-2 text-muted">Oleh: {{ $course->user->name }}</p>

                    <div class="mb-3">
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-success btn-sm">Detail</a>
                        <form method="POST" action="{{ route('courses.destroy', $course) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                        </form>
                    </div>

                    {{-- SubCourses --}}
                    @if($course->subCourses->count())
                        <div class="ms-3">
                            @foreach($course->subCourses as $sub)
                            <div class="card mb-3 border">
                                <div class="card-body">
                                    <h6 class="card-title">🧩 {{ $sub->nama_course }}</h6>
                                    <p class="card-subtitle text-muted mb-2">Oleh: {{ $sub->user->name ?? '-' }}</p>

                                    @php
                                        function getYoutubeEmbedUrl($url) {
                                            if (preg_match('/youtu\.be\/([^\?]*)/', $url, $matches)) {
                                                return 'https://www.youtube.com/embed/' . $matches[1];
                                            } elseif (preg_match('/youtube\.com.*v=([^&]*)/', $url, $matches)) {
                                                return 'https://www.youtube.com/embed/' . $matches[1];
                                            }
                                            return null;
                                        }
                                        $embedUrl = getYoutubeEmbedUrl($sub->link_video);
                                    @endphp

                                    @if($embedUrl)
                                        <div class="ratio ratio-16x9 mb-3">
                                            <iframe src="{{ $embedUrl }}" allowfullscreen></iframe>
                                        </div>
                                    @else
                                        <p class="text-danger small">Link video tidak valid.</p>
                                    @endif

                                    <a href="{{ route('sub-courses.edit', $sub) }}" class="btn btn-sm btn-outline-primary">Edit SubCourse</a>
                                    <form method="POST" action="{{ route('sub-courses.destroy', $sub) }}" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="fst-italic text-muted ms-3">Belum ada SubCourse.</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
