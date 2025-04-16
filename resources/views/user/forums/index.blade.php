@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Forum yang Tersedia</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($forums as $forum)
            <div class="bg-white rounded-xl shadow-md p-5">
                <h3 class="text-lg font-semibold mb-3">{{ $forum->name }}</h3>

                @if(in_array($forum->id, $joinedForums))
                    <button class="bg-green-600 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                        ✅ Sudah Bergabung
                    </button>
                @elseif(in_array($forum->id, $requestedForums))
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                        ⏳ Menunggu Persetujuan
                    </button>
                @else
                    <form action="{{ route('user.forums.request', $forum->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            ➕ Request Join
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
