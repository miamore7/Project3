@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="h4 mb-4 fw-bold">Tambah Course</h1>

                {{-- Tampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_course" class="form-label">Nama Course</label>
                        <input type="text" name="nama_course" id="nama_course" class="form-control" required value="{{ old('nama_course') }}">
                    </div>

                    <div class="mb-3">
                        <label for="link_video" class="form-label">Link Video</label>
                        <input type="url" name="link_video" id="link_video" class="form-control" value="{{ old('link_video') }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
        </div>
    </div>
</div>
@endsection
