@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-3xl font-bold">
            {{ __('Profile') }}
        </h2>

        <p class="text-gray-600">
            {{ __('Welcome to your profile page!') }}
        </p>

        {{-- profile image in circle avatar --}}
        <div class="mb-4">
            {{-- if user image is not available use solid color and user first character name as avatar --}}
            @if (Auth::user()->profile_image == null)
                <div class="bg-blue-700 rounded-full w-32 h-32 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white ">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
            @else
                <img src="{{ Auth::user()->profile_image }}" alt="Profile Image"
                    class="border border-x border-black rounded-full w-32 h-32">
            @endif
        </div>


        <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
    </div>
@endsection
