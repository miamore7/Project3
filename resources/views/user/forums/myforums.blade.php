@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Forum yang Kamu Ikuti</h2>

    <!-- Forums Container -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($forums as $forum)
        <div class="card border rounded-lg shadow-lg">
            <div class="card-body p-4">
                <h5 class="card-title text-xl font-semibold">{{ $forum->name }}</h5>
                <p class="card-text text-gray-700 mb-4">{{ $forum->description }}</p>

                <!-- Button to start the forum chat -->
                <a href="{{ route('user.forums.chat.show', $forum->id) }}">
                    <button class="btn btn-primary w-full">Start Forum</button>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
