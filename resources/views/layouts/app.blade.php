<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- change title to be "Amore" --}}
    <meta name="description" content="Amore - Find Your Mentor">
    {{-- <title>{{ config('app.name', 'Amore') }}</title> --}}
    <title>Amore - Find Your Mentor</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRAB2fY1Gz2z5k1Xz8gWi6jo0DP78Vs5Z3vVXI4brO3fF9Kk7tVZz5Ndu" crossorigin="anonymous">
    {{-- use tailwind css --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
        integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous">
    </script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="bg-gray-100 anti-aliasing">
    <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Amore
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        {{ __('View Profile') }}
                                    </a>

                                    {{-- view course --}}
                                    <a class="dropdown-item" href="{{ route('admin.courses.index') }}">
                                        {{ __('My Courses') }}

                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            {{ __('Edit Profile') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                </div>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        {{-- floats on the bottom of screen --}}
        <footer class="bg-gray-800 text-white text-center py-4 mt-auto fixed-bottom">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <p style="font-size: 14px; margin-bottom: 10px;">&copy; 2025 Find Your Mentor. All Rights Reserved.</p>
                <div>
                    <a href="#"
                        style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 16px;">Privacy
                        Policy</a>
                    <a href="#" style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 16px;">Terms
                        of
                        Service</a>
                    <a href="#"
                        style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 16px;">Contact
                        Us</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Alpine.js (if needed for other parts) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
