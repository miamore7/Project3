<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Admin Panel</title>
    
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .transition {
            transition: all 0.3s ease;
        }
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="flex">
        @include('components.admin.sidebar')
        
        <div class="flex-1 ml-64">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900">@yield('header')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>
            
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>