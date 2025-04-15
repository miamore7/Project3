<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'CourseApp') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'CourseApp') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
=======
{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; text-align: center;">
    {{-- Text Content --}}
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 36px; margin-bottom: 20px;">Find your right mentor</h1>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Learn from experts <br> Grow your hobby</p>
        <button style="background-color: #000000; color: #FFFFFFFF; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; margin-bottom: 20px;">Get Started</button>
    </div>
</div>
<div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-top: 30px; text-align: center;">
    <div style="width: 25%; margin-bottom: 20px;">
        <p>34+</p>
        <p>Courses</p>
    </div>
    <div style="width: 25%; margin-bottom: 20px;">
        <p>245K</p>
        <p>Followers And Students</p>
    </div>
    <div style="width: 25%; margin-bottom: 20px;">
        <p>15+</p>
        <p>Profesional Coaches</p>
    </div>
    <div style="width: 25%; margin-bottom: 20px;">
        <p>4.89</p>
        <p>Ratings</p>
    </div>
</div>

{{-- Images Section --}}
<div style="display: flex; justify-content: space-between; margin-bottom: 0; padding-bottom:0;">
    <img src="{{ asset('images/Person1.jpg') }}" alt="Person 1" style="width:35%;">
    <img src="{{ asset('images/Person2.jpg') }}" alt="Person 2" style="width: 35%;">
    <img src="{{ asset('images/Person3.jpg') }}" alt="Person 3" style="width: 35%;">
    <img src="{{ asset('images/Person4.jpg') }}" alt="Person 4" style="width: 35%;">
</div>

@endsection
>>>>>>> 41f6155a9ca21f6c5d8522fd000900d6ad822ae6
