@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg h-screen fixed flex flex-col">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
        </div>
        
        <!-- Main Menu -->
        <nav class="mt-4 flex-grow">
            <div class="px-4 py-2 text-sm font-medium text-gray-500 uppercase tracking-wider">
                Menu Utama
            </div>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
                <span class="mr-3">📊</span>
                Dashboard
            </a>
            
            <a href="{{ route('admin.courses.index') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.courses.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
                <span class="mr-3">📚</span>
                Kelola Course
            </a>
            
            <a href="{{ route('admin.sub-courses.index') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.sub-courses.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
                <span class="mr-3">🧩</span>
                Kelola SubCourse
            </a>
            
            <a href="{{ route('admin.forums.index') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.forums.index') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
                <span class="mr-3">💬</span>
                Kelola Forum
            </a>
            
            <a href="{{ route('admin.forum.requests') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.forum.requests') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
                <span class="mr-3">📥</span>
                Permintaan Join
                @if(isset($jumlahRequestPending) && $jumlahRequestPending > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                        {{ $jumlahRequestPending }}
                    </span>
                @endif
            </a>
        </nav>

        User Menu at Bottom
        <!-- <div class="mt-auto border-t">
            <div class="px-4 py-2 text-sm font-medium text-gray-500 uppercase tracking-wider">
                User Menu
            </div>
            <a href="{{ route('profile.show') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                <span class="mr-3">👤</span>
                View Profile
            </a>
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                <span class="mr-3">✏️</span>
                Edit Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition text-left">
                    <span class="mr-3">🚪</span>
                    Logout
                </button>
            </form>
        </div> -->
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64 p-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        {{-- Statistik singkat --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-white rounded shadow">
                <p class="text-gray-500">User Aktif</p>
                <p class="text-3xl font-bold">{{ $jumlahUserAktif }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <p class="text-gray-500">Course</p>
                <p class="text-3xl font-bold">{{ $jumlahCourse }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <p class="text-gray-500">Kelas (Sub-course)</p>
                <p class="text-3xl font-bold">{{ $jumlahSubCourse }}</p>
            </div>
        </div>

        {{-- Chart --}}
        <div class="bg-white p-6 rounded shadow">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['User Aktif', 'Course', 'Sub-course'],
            datasets: [{
                label: 'Statistik',
                data: [
                    {{ $jumlahUserAktif }},
                    {{ $jumlahCourse }},
                    {{ $jumlahSubCourse }}
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection