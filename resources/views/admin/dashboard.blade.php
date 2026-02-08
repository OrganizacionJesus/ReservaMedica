@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $temaDinamico = $admin->tema_dinamico ?? false;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700';
    
    $baseColorClass = '';
    $baseColorStyle = '';
    
    if ($temaDinamico) {
        if (str_starts_with($bannerColor, '#')) {
            $baseColorStyle = "background: linear-gradient(135deg, {$bannerColor} 0%, " . adjustBrightness($bannerColor, -20) . " 100%);";
        } else {
            $baseColorClass = $bannerColor;
        }
    }

    if (!function_exists('adjustBrightness')) {
        function adjustBrightness($hex, $steps) {
            $steps = max(-255, min(255, $steps));
            $hex = str_replace('#', '', $hex);
            if (strlen($hex) == 3) {
                $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
            }
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $r = max(0, min(255, $r + $steps));
            $g = max(0, min(255, $g + $steps));
            $b = max(0, min(255, $b + $steps));
            return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
                . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
                . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
        }
    }
@endphp

@section('title', 'Dashboard Administrativo')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
        overflow: hidden; /* Prevent overflow */
    }
    .dark .glass-card {
        background: rgba(17, 24, 39, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3);
    }
    
    /* Chart Container improvements */
    .chart-wrapper {
        min-height: 300px;
        width: 100%;
        position: relative;
        padding: 0 10px; /* Safety padding */
    }

    .stat-hover {
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-hover:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
{{-- Premium Header --}}
<div class="relative overflow-hidden rounded-3xl mb-8 {{ $baseColorClass }} shadow-xl border border-white/20" style="{{ $baseColorStyle }}">
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600"></div>
    @endif
    
    {{-- Decorative Orbs --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-2xl -ml-20 -mb-20"></div>

    <div class="relative z-10 p-8">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-8">
            <div class="text-white">
                <h2 class="text-3xl font-display font-bold mb-2">
                    ¡Bienvenido, {{ $admin->primer_nombre }}! 👋
                </h2>
                <p class="text-white/80 font-medium flex items-center gap-2">
                    <i class="bi bi-calendar4"></i>
                    @php \Carbon\Carbon::setLocale('es'); @endphp
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 w-full xl:w-auto">
                @foreach([
                    ['icon' => 'person-badge', 'value' => $stats['medicos'], 'label' => 'Médicos', 'bg' => 'bg-emerald-500/20', 'route' => route('medicos.index')],
                    ['icon' => 'people', 'value' => $stats['pacientes'], 'label' => 'Pacientes', 'bg' => 'bg-blue-500/20', 'route' => route('pacientes.index')],
                    ['icon' => 'calendar-check', 'value' => $stats['citas_hoy'], 'label' => 'Citas Hoy', 'bg' => 'bg-amber-500/20', 'route' => route('citas.index')],
                    ['icon' => 'currency-dollar', 'value' => number_format($stats['ingresos_mes']/1000, 1) . 'k', 'label' => 'Ingresos', 'bg' => 'bg-purple-500/20', 'route' => route('pagos.index')]
                ] as $stat)
                <a href="{{ $stat['route'] }}" class="block bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 hover:bg-white/20 transition-all cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $stat['bg'] }} flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <i class="bi bi-{{ $stat['icon'] }} text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-white leading-none">{{ $stat['value'] }}</p>
                            <p class="text-[11px] font-bold text-white/70 uppercase tracking-wide mt-1">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-12 gap-6">
    {{-- Left Column (Charts) --}}
    <div class="col-span-12 lg:col-span-8 space-y-6">
        
        {{-- Charts Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Weekly Chart --}}
            <a href="{{ route('citas.index') }}" class="glass-card p-6 h-full flex flex-col block hover:shadow-lg transition-shadow cursor-pointer">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg group-hover:text-blue-600 transition-colors">Actividad Semanal</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total citas últimos 7 días</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold dark:bg-blue-900/30 dark:text-blue-300">
                        {{ array_sum($chartData['weekly']['data']) }} citas
                    </span>
                </div>
                <div class="chart-wrapper flex-1">
                    <div id="weeklyChart" class="h-full w-full pointer-events-none"></div>
                </div>
            </a>

            {{-- Status Distribution --}}
            <a href="{{ route('citas.index') }}" class="glass-card p-6 h-full flex flex-col block hover:shadow-lg transition-shadow cursor-pointer">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">Distribución</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado de citas</p>
                    </div>
                    <div class="flex items-center gap-2">
                         <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                         <span class="text-xs text-gray-500 font-medium">Completadas</span>
                    </div>
                </div>
                <div class="chart-wrapper flex-1 d-flex items-center justify-center">
                    <div id="statusChart" class="h-full w-full pointer-events-none"></div>
                </div>
            </a>
        </div>

        {{-- Revenue Chart --}}
        <a href="{{ route('pagos.index') }}" class="glass-card p-6 block hover:shadow-lg transition-shadow cursor-pointer">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">Ingresos Mensuales</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Rendimiento financiero {{ now()->year }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['ingresos_mes']) }}</p>
                        <p class="text-xs font-bold {{ $stats['crecimiento_ingresos'] >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $stats['crecimiento_ingresos'] > 0 ? '+' : '' }}{{ $stats['crecimiento_ingresos'] }}% vs mes anterior
                        </p>
                    </div>
                </div>
            </div>
            <div class="chart-wrapper" style="height: 350px;">
                <div id="revenueChart" class="h-full w-full pointer-events-none"></div>
            </div>
        </a>
    </div>

    {{-- Right Column (Sidebar) --}}
    <div class="col-span-12 lg:col-span-4 space-y-6">
        
        {{-- Tasks Card --}}
        <a href="{{ route('citas.index') }}" class="glass-card p-6 block hover:shadow-lg transition-shadow cursor-pointer">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-gray-900 dark:text-white text-lg">Tareas Pendientes</h3>
                <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-lg text-xs font-bold dark:bg-amber-900/30 dark:text-amber-300">
                    Prioridad
                </span>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['title' => 'Citas sin confirmar', 'count' => $tareas['citas_sin_confirmar'], 'color' => 'amber', 'icon' => 'exclamation-circle'],
                    ['title' => 'Pagos en revisión', 'count' => $tareas['pagos_pendientes'], 'color' => 'rose', 'icon' => 'wallet2'],
                    ['title' => 'Resultados Lab', 'count' => $tareas['resultados_pendientes'], 'color' => 'blue', 'icon' => 'file-earmark-medical']
                ] as $task)
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800 border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-all stat-hover group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-{{ $task['color'] }}-100 dark:bg-{{ $task['color'] }}-900/30 flex items-center justify-center text-{{ $task['color'] }}-600 dark:text-{{ $task['color'] }}-400">
                            <i class="bi bi-{{ $task['icon'] }}"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $task['title'] }}</span>
                    </div>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $task['count'] }}</span>
                </div>
                @endforeach
            </div>
        </a>

        {{-- Activity Feed --}}
        <a href="{{ route('admin.notificaciones.index') }}" class="glass-card p-6 block hover:shadow-lg transition-shadow cursor-pointer">
            <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-6">Actividad</h3>
            <div class="relative pl-4 border-l-2 border-gray-100 dark:border-gray-800 space-y-6">
                @forelse($actividadReciente as $actividad)
                <div class="relative group">
                    <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-blue-500 border-4 border-white dark:border-gray-900 group-hover:scale-125 transition-transform"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $actividad->descripcion }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($actividad->created_at)->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-400">
                    <p class="text-sm">Sin actividad reciente</p>
                </div>
                @endforelse
            </div>
        </a>

        {{-- Quick Actions --}}
        <div class="glass-card p-6">
            <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-4">Acciones</h3>
            <div class="grid grid-cols-2 gap-3">
                @if($admin->tipo_admin === 'Root')
                <a href="{{ route('medicos.create') }}" class="p-4 rounded-xl bg-violet-50 dark:bg-violet-900/20 hover:bg-violet-100 dark:hover:bg-violet-900/30 transition-colors text-center group">
                    <i class="bi bi-person-badge text-2xl text-violet-600 dark:text-violet-400 mb-2 block group-hover:scale-110 transition-transform"></i>
                    <span class="text-xs font-bold text-violet-700 dark:text-violet-300">Nuevo Médico</span>
                </a>
                @else
                <a href="{{ route('pagos.create') }}" class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors text-center group">
                    <i class="bi bi-wallet2 text-2xl text-emerald-600 dark:text-emerald-400 mb-2 block group-hover:scale-110 transition-transform"></i>
                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-300">Registrar Pago</span>
                </a>
                @endif
                <a href="{{ route('pacientes.create') }}" class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors text-center group">
                    <i class="bi bi-person-add text-2xl text-blue-600 dark:text-blue-400 mb-2 block group-hover:scale-110 transition-transform"></i>
                    <span class="text-xs font-bold text-blue-700 dark:text-blue-300">Nuevo Paciente</span>
                </a>
                <a href="{{ route('citas.create') }}" class="col-span-2 p-3 rounded-xl bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors text-center flex items-center justify-center gap-2 group text-white dark:text-gray-900">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span class="text-sm font-bold">Nueva Cita</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
<script>
    const chartData = @json($chartData);
    const isDark = document.documentElement.classList.contains('dark');
    
    const theme = {
        font: 'Inter, system-ui, sans-serif',
        text: isDark ? '#9ca3af' : '#6b7280',
        grid: isDark ? '#374151' : '#f3f4f6'
    };

    // Improved Weekly Chart - Fit to Container
    new ApexCharts(document.querySelector("#weeklyChart"), {
        series: [{ name: 'Citas', data: chartData.weekly.data }],
        chart: { 
            type: 'area', 
            height: '100%', 
            width: '100%',
            toolbar: { show: false }, 
            parentHeightOffset: 0,
            zoom: { enabled: false }
        },
        stroke: { curve: 'smooth', width: 3, colors: ['#3b82f6'] },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 90, 100] } },
        dataLabels: { enabled: false },
        xaxis: { 
            categories: chartData.weekly.labels, 
            labels: { show: false }, // Hide X labels for cleaner mini-chart look
            axisBorder: { show: false }, 
            axisTicks: { show: false },
            tooltip: { enabled: false }
        },
        yaxis: { show: false }, // Hide Y Axis
        grid: { show: false, padding: { top: 0, right: 0, bottom: 0, left: 0 } }, // Remove grid & padding
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // Improved Status Donut - Better Fit
    new ApexCharts(document.querySelector("#statusChart"), {
        series: chartData.status.data,
        chart: { 
            type: 'donut', 
            height: 220, // Specific height for donut to fit better
            fontFamily: theme.font
        },
        labels: chartData.status.labels,
        colors: ['#10b981', '#3b82f6', '#f59e0b', '#f43f5e'],
        legend: { position: 'bottom', fontSize: '12px', labels: { colors: theme.text } },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        value: { fontSize: '24px', fontWeight: 700, color: isDark ? '#fff' : '#111827', offsetY: 5 },
                        total: { 
                            show: true, 
                            label: 'Total', 
                            fontSize: '12px',
                            color: theme.text, 
                            formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0) 
                        }
                    }
                }
            }
        },
        stroke: { show: false }
    }).render();

    // Improved Revenue Chart
    new ApexCharts(document.querySelector("#revenueChart"), {
        series: [{ name: 'Ingresos', data: chartData.revenue.data }],
        chart: { 
            type: 'bar', 
            height: '100%', 
            width: '100%',
            toolbar: { show: false },
            parentHeightOffset: 0
        },
        plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
        colors: ['#8b5cf6'],
        xaxis: { 
            categories: chartData.revenue.labels, 
            labels: { 
                style: { colors: theme.text, fontSize: '11px', fontFamily: theme.font },
                rotate: 0 
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { 
            labels: { 
                formatter: (val) => '$' + (val/1000).toFixed(0) + 'k',
                style: { colors: theme.text, fontSize: '11px' }
            } 
        },
        grid: { 
            borderColor: theme.grid, 
            strokeDashArray: 4,
            padding: { top: 0, right: 0, bottom: 0, left: 10 }
        },
        dataLabels: { enabled: false },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();
</script>
@endpush
