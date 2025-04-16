@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h2 class="text-2xl font-bold mb-6">Daftar Forum</h2>
    <a href="{{ route('admin.forums.create') }}" class="btn btn-primary mb-4">+ Buat Forum</a>

    <!-- Forums List as Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($forums as $forum)
        <div class="card border rounded-lg shadow-lg p-4">
            <div class="card-body">
                <h5 class="card-title text-xl font-semibold">{{ $forum->name }}</h5>
                <p class="card-text text-gray-700">Anggota: {{ $forum->members->count() }}</p>
            </div>
            <div class="card-footer flex justify-between items-center">
                <!-- Delete Form -->
                <form action="{{ route('admin.forums.destroy', $forum) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus forum?')" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
