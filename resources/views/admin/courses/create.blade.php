@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 id="titleContent" class="text-2xl mb-4 fw-bold">
            {{ __('Tambah Course') }}
        </h1>

        <div class="col-md-8 w-100 mx-auto">
            <div class="w-full border rounded-lg shadow-sm bg-white p-4">
                <div class="card-body">

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

                    <form method="POST" action="{{ route('admin.courses.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_course" class="form-label">Nama Course</label>
                            <input type="text" name="nama_course" id="nama_course" class="form-control" required
                                value="{{ old('nama_course') }}">
                        </div>

                        <div class="mb-3">
                            <label for="link_video" class="form-label">Link Video</label>
                            <input type="url" name="link_video" id="link_video" class="form-control"
                                value="{{ old('link_video') }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
