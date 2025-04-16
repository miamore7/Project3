@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h2 class="text-2xl font-bold mb-6">Permintaan Join Forum</h2>

    <!-- Requests List as Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($requests as $req)
        <div class="card border rounded-lg shadow-lg p-4">
            <div class="card-body">
                <h5 class="card-title text-xl font-semibold">{{ $req->user->name }}</h5>
                <p class="card-text text-gray-700">Ingin join forum: <strong>{{ $req->forum->name }}</strong></p>
            </div>
            <div class="card-footer flex justify-between items-center">
                <!-- Approve Button -->
                <form action="{{ route('admin.forum.requests.approve', $req->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Terima</button>
                </form>
                <!-- Reject Button -->
                <form action="{{ route('admin.forum.requests.reject', $req->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center w-full">Tidak ada permintaan saat ini.</p>
        @endforelse
    </div>
</div>
@endsection
