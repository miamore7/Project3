@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
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

    {{-- Navigasi --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('courses.index') }}" class="block bg-green-100 hover:bg-green-200 text-green-900 p-6 rounded-xl shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="text-4xl">📚</div>
                <div>
                    <h3 class="text-xl font-semibold">Kelola Course</h3>
                    <p class="text-sm text-green-800">Lihat dan atur daftar course utama.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('sub-courses.index') }}" class="block bg-green-100 hover:bg-green-200 text-green-900 p-6 rounded-xl shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="text-4xl">🧩</div>
                <div>
                    <h3 class="text-xl font-semibold">Kelola SubCourse</h3>
                    <p class="text-sm text-green-800">Kelola sub-course untuk setiap materi.</p>
                </div>
            </div>
        </a>
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
