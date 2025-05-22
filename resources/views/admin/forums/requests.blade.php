@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-4 shadow min-h-screen">
        @include('layouts.partials.admin_sidebar')
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-6">Permintaan Join Forum</h2>

        <!-- Requests List as Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($requests as $req)
            <div class="border rounded-lg shadow p-4 flex flex-col justify-between">
                <div>
                    <h5 class="text-xl font-semibold">{{ $req->user->name }}</h5>
                    <p class="text-gray-700">Ingin join forum: <strong>{{ $req->forum->name }}</strong></p>
                </div>
                <div class="flex justify-between mt-4">
                    <!-- Approve Button -->
                    <form action="{{ route('admin.forum.requests.approve', $req->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition">
                            Terima
                        </button>
                    </form>
                    <!-- Reject Button -->
                    <form action="{{ route('admin.forum.requests.reject', $req->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-center w-full">Tidak ada permintaan saat ini.</p>
            @endforelse
        </div>
    </main>
</div>
@endsection
