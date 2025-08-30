@extends('layouts._partials.layout')

@section('title','Información General')
@section('subtitle','Resumen del sistema')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8"><h1 class="txt-title1">REGISTROS DEL SISTEMA</h1></div>
    <div class="w-4/5 mx-auto mb-5">
        <canvas id="dashboardChart"></canvas>
    </div>
    <section id="services" class="text-center">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
            <div data-chart="pacientes" class="transform hover:scale-105 transition duration-300 p-6">
                <h5 class="text-xl font-semibold mb-4 text-cyan-700 dark:text-cyan-300">Pacientes</h5>
                <p class="text-3xl font-bold mt-2 text-white">{{ $totalPatients }}</p>
            </div>
            <div data-chart="citas" class="transform hover:scale-105 transition duration-300 p-6">
                <h5 class="text-xl font-semibold mb-4 text-cyan-700 dark:text-cyan-300">Citas</h5>
                <p class="text-3xl font-bold mt-2 text-white">{{ $totalEvents }}</p>
            </div>
            <div data-chart="radiografias" class="transform hover:scale-105 transition duration-300 p-6">
                <h5 class="text-xl font-semibold mb-4 text-cyan-700 dark:text-cyan-300">Radiografías</h5>
                <p class="text-3xl font-bold mt-2 text-white">{{ $totalRadiographies }}</p>
            </div>
            <div data-chart="tomografias" class="transform hover:scale-105 transition duration-300 p-6">
                <h5 class="text-xl font-semibold mb-4 text-cyan-700 dark:text-cyan-300">Tomografías</h5>
                <p class="text-3xl font-bold mt-2 text-white">{{ $totalTomographies }}</p>
            </div>
            <div data-chart="reportes" class="transform hover:scale-105 transition duration-300 p-6">
                <h5 class="text-xl font-semibold mb-4 text-cyan-700 dark:text-cyan-300">Reportes</h5>
                <p class="text-3xl font-bold mt-2 text-white">{{ $totalReports }}</p>
            </div>
            <div data-chart="usuarios" class="transform hover:scale-105 transition duration-300 p-6">
                <h5 class="text-xl font-semibold mb-4 text-cyan-700 dark:text-cyan-300">Usuarios</h5>
                <p class="text-3xl font-bold mt-2 text-white">{{ $totalUsers }}</p>
            </div>
    </section>
    <div class="mb-8"><h1 class="txt-title2">REPORTE MENSUAL 2025</h1></div>
    <div class="w-4/5 mx-auto mb-5">
        <canvas id="dashboardMounth"></canvas>
    </div>
    <div class="mt-10 mb-4"><h1 class="txt-title1">RESUMEN 2025</h1></div>
    <div class="overflow-x-auto pl-10 pr-10">
    <table class="min-w-full border border-cyan-600 rounded-lg overflow-hidden">
        <thead class="bg-cyan-800 text-cyan-200">
            <tr>
                <th class="px-4 py-2 border border-cyan-600">Mes</th>
                <th class="px-4 py-2 border border-cyan-600">Pacientes</th>
                <th class="px-4 py-2 border border-cyan-600">Radiografías</th>
                <th class="px-4 py-2 border border-cyan-600">Tomografías</th>
                <th class="px-4 py-2 border border-cyan-600">Citas</th>
                <th class="px-4 py-2 border border-cyan-600">Reportes</th>
                <th class="px-4 py-2 border border-cyan-600">Usuarios</th>
            </tr>
        </thead>
            <tbody>
                @php
                    $months = [
                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                    ];
                @endphp

                @foreach($months as $i => $monthName)
                    <tr class="text-center {{ $i % 2 == 0 ? 'bg-gray-700' : 'bg-gray-800' }}">
                        <td class="px-4 py-2 border border-cyan-700 text-white">{{ $monthName }}</td>
                        <td class="px-4 py-2 border border-cyan-700">{{ $monthlyPatients[$i-1] }}</td>
                        <td class="px-4 py-2 border border-cyan-700">{{ $monthlyRadiographies[$i-1] }}</td>
                        <td class="px-4 py-2 border border-cyan-700">{{ $monthlyTomographies[$i-1] }}</td>
                        <td class="px-4 py-2 border border-cyan-700">{{ $monthlyEvents[$i-1] }}</td>
                        <td class="px-4 py-2 border border-cyan-700">{{ $monthlyReports[$i-1] }}</td>
                        <td class="px-4 py-2 border border-cyan-700">{{ $monthlyUsers[$i-1] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    const dataValues = {!! json_encode([
        $totalUsers,
        $totalPatients,
        $totalEvents,
        $totalRadiographies,
        $totalTomographies,
        $totalReports
    ]) !!};

    const data = {
        labels: [
            'Usuarios', 'Pacientes', 'Eventos', 'Radiografías', 'Tomografías', 'Reportes'
        ],
        datasets: [{
            label: 'Registros totales',
            data: dataValues,
            backgroundColor: 'rgba(138, 43, 226, 0.5)',
            borderColor: 'rgba(138, 43, 226, 1)',
            borderWidth: 2,
            borderRadius: 5
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'white',
                        font: { size: 14 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white',
                        font: { size: 12 }
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'white',
                        font: { size: 12 }
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.1)'
                    }
                }
            }
        }
    };

    new Chart(
        document.getElementById('dashboardChart'), config
    );

    const monthLabels = [
        'Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
    ];

    const monthlyData = {
        pacientes: @json($monthlyPatients),
        citas: @json($monthlyEvents),
        radiografias: @json($monthlyRadiographies),
        tomografias: @json($monthlyTomographies),
        reportes: @json($monthlyReports),
        usuarios: @json($monthlyUsers),
    };
    
    const monthlyGeneral = monthLabels.map((_, i) =>
        monthlyData.pacientes[i] +
        monthlyData.citas[i] +
        monthlyData.radiografias[i] +
        monthlyData.tomografias[i] +
        monthlyData.reportes[i] +
        monthlyData.usuarios[i]
    );

    const ctxMonth = document.getElementById('dashboardMounth').getContext('2d');
    let monthChart = new Chart(ctxMonth, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Registros 2025 (General)',
                data: monthlyGeneral,
                borderColor: 'rgba(0, 185, 0, 1)',  
                backgroundColor: 'rgba(0, 201, 0, 0.3)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: 'white' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: 'white' },
                    grid: { color: 'rgba(255,255,255,0.1)' }
                },
                x: {
                    ticks: { color: 'white' },
                    grid: { color: 'rgba(255,255,255,0.1)' }
                }
            }
        }
    });
    function updateMonthChart(type) {
        const dataset = type === 'general'
            ? monthlyGeneral
            : monthlyData[type];

        monthChart.data.datasets[0].data = dataset;
        monthChart.data.datasets[0].label =
            type === 'general'
                ? 'Registros 2025 (General)'
                : `Registros 2025 (${type})`;

        monthChart.update();
    }
    document.querySelectorAll('[data-chart]').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            const type = el.getAttribute('data-chart');
            updateMonthChart(type);
        });
    });
</script>
@endpush

@endsection
