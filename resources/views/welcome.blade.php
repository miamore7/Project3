{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg p-6 mt-10 mb-10">
        <div style="margin-bottom: 30px;" class="text-center text-bold">
            <h1 class="mb-4 font-bold text-5xl">Find your right mentor</h1>
            <p class="text-gray-800 line-height-1.5 text-2xl">Learn from experts
                <br>Grow your hobby
            </p>

            <a href="{{ route('register') }}"
                class="bg-black text-white text-md no-underline font-bold py-2 px-4 rounded hover:bg-gray-800 transition duration-300 ease-in-out">
                Get Started
            </a>
        </div>
    </div>

    {{-- statistik pengguna --}}
    {{-- style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-top: 30px; text-align: center;" --}}
    <div class="flex w-fit flex-wrap justify-between mt-8 text-center py-6 bg-gray-200">
        {{-- style="width: 25%; margin-bottom: 20px;" --}}
        <div class="w-1/4 mb-[20px]">
            <p class="text-xl font-bold text-gray-800">
                {{ isset($course) ? $course->count() : 45 }}</p>
            <p class="text-md font-semibold text-gray-600">
                {{ isset($course) ? $course->count() : __('Courses') }}
            </p>
        </div>

        {{-- style="width: 25%; margin-bottom: 20px;" --}}
        <div class="w-1/4 mb-[20px]">
            <p class="text-xl font-bold text-gray-800">
                {{ isset($studentsTotal) ? $studentsTotal : __('245K') }}
            </p>
            <p class="text-md font-semibold text-gray-600">
                Followers And Students
            </p>
        </div>

        <div class="w-1/4 mb-[20px]">
            <p class="text-xl font-bold text-gray-800">
                15+
            </p>
            <p class="text-md font-semibold text-gray-600">
                Profesional Coaches
            </p>
        </div>


        {{-- <div style="width: 25%; margin-bottom: 20px;"> --}}
        <div class="w-1/4 mb-[20px]">
            <p class="text-xl font-bold text-gray-800">
                4.89
            </p>
            <p class="text-md font-semibold text-gray-600">
                Ratings
            </p>
        </div>
    </div>
    {{-- akhir div dari statistik --}}

    {{-- Images Section --}}
    {{-- style="display: flex; justify-content: space-between; margin-bottom: 0; padding-bottom:0;"" --}}
    <div class="flex overflow-x-auto justify-between mb-0 pb-0 w-full">
        {{-- style="width: 35%; margin-bottom: 20px;" --}}
        <img src="{{ asset('images/Person1.jpg') }}" alt="Person 1" style="width:35%;">
        <img src="{{ asset('images/Person2.jpg') }}" alt="Person 2" style="width: 35%;">
        <img src="{{ asset('images/Person3.jpg') }}" alt="Person 3" style="width: 35%;">
        <img src="{{ asset('images/Person4.jpg') }}" alt="Person 4" style="width: 35%;">
    </div>
@endsection
