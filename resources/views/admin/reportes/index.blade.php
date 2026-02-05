@extends('layouts.admin')

@section('title', 'Reportes y Estadísticas')

@section('content')
    <div class="space-y-6">
        <!-- Header Premium -->
        <div
            class="relative overflow-hidden rounded-3xl shadow-xl bg-gradient-to-br from-medical-500 to-medical-600 p-8 text-white">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-display font-bold tracking-tight">Análisis del Sistema</h2>
                    <p class="text-medical-50 mt-2 opacity-90 max-w-2xl font-medium">
                        Visualiza el rendimiento de {{ $isRoot ? 'toda la red médica' : 'tus consultorios' }} en tiempo
                        real.
                    </p>
                </div>

                <!-- Selector de Fecha Global -->
                <form action="{{ route('reportes.index') }}" method="GET"
                    class="flex flex-wrap items-center gap-3 bg-white/10 backdrop-blur-md p-2 rounded-2xl ring-1 ring-white/20">
                    <div class="flex items-center gap-2 px-3 py-2 bg-white/10 rounded-xl border border-white/10">
                        <i class="bi bi-calendar3 text-medical-200"></i>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="bg-transparent border-none text-white text-sm focus:ring-0 cursor-pointer">
                        <span class="text-white/40">-</span>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="bg-transparent border-none text-white text-sm focus:ring-0 cursor-pointer">
                    </div>
                    <button type="submit"
                        class="bg-white text-medical-600 px-5 py-2 rounded-xl font-bold text-sm hover:bg-medical-50 transition-colors shadow-lg">
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- Orbes de fondo -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full blur-2xl -ml-10 -mb-10"></div>
        </div>

        <!-- KPIs Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Citas Totales -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-medical-500 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                        <i class="bi bi-calendar2-range text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Citas
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalCitas) }}
                        </h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span
                        class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-bold">PERIODO
                        SELECCIONADO</span>
                </div>
            </div>

            <!-- Ingresos USD -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-emerald-500 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                        <i class="bi bi-currency-dollar text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Ingresos
                            Totales</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            ${{ number_format($ingresosTotal, 2) }}</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span
                        class="px-2 py-1 rounded-md bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold">FACTURADO</span>
                </div>
            </div>

            <!-- Ausentismo -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-rose-500 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400 group-hover:scale-110 transition-transform">
                        <i class="bi bi-person-x text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">No-Show Rate
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $noShowRate }}%</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span
                        class="px-2 py-1 rounded-md bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 text-[10px] font-bold">AUSENTISMO</span>
                </div>
            </div>

            <!-- Eficiencia -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-amber-500 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                        <i class="bi bi-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Efectividad
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $totalCitas > 0 ? round(($citasCompletadas / $totalCitas) * 100, 1) : 0 }}%
                        </h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span
                        class="px-2 py-1 rounded-md bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10px] font-bold">CITAS
                        COMPLETADAS</span>
                </div>
            </div>
        </div>

        <!-- Main Content Reports Navigation -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Operatividad Card -->
            <a href="{{ route('reportes.operatividad') }}"
                class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-500">
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-blue-500 text-white flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="bi bi-speedometer2 text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mt-6 text-gray-900 dark:text-white">Reportes Operativos</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ausentismo, productividad médica y tiempos de
                        espera de los pacientes.</p>
                    <div class="mt-6 flex items-center text-blue-600 font-bold text-sm">
                        Ir al detalle <i class="bi bi-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-50 dark:bg-blue-900/10 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
            </a>

            <!-- Financiero Card -->
            <a href="{{ route('reportes.financiero') }}"
                class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-500">
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="bi bi-cash-stack text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mt-6 text-gray-900 dark:text-white">Análisis Financiero</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ingresos por sede, métodos de pago y
                        conciliación de cuentas.</p>
                    <div class="mt-6 flex items-center text-emerald-600 font-bold text-sm">
                        Ver finanzas <i class="bi bi-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-50 dark:bg-emerald-900/10 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
            </a>

            <!-- Clínico Card -->
            <a href="{{ route('reportes.clinico') }}"
                class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-500">
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-purple-500 text-white flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="bi bi-clipboard2-pulse text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mt-6 text-gray-900 dark:text-white">Estadísticas Clínicas</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Diagnósticos recurrentes, demografía y
                        procedencia de pacientes.</p>
                    <div class="mt-6 flex items-center text-purple-600 font-bold text-sm">
                        Explorar datos <i class="bi bi-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-40 h-40 bg-purple-50 dark:bg-purple-900/10 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
            </a>
        </div>

        <!-- Placeholder for Charts (Implemented in sub-views or further down index) -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Tendencia Mensual de Citas</h4>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-xs font-medium text-gray-500">
                        <span class="w-2.5 h-2.5 rounded-full bg-medical-500"></span> Completadas
                    </span>
                    <span class="flex items-center gap-1.5 text-xs font-medium text-gray-500">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> No Asistió
                    </span>
                </div>
            </div>
            <div class="h-80 w-full relative">
                <canvas id="tendenciaCitasChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('tendenciaCitasChart').getContext('2d');
            const data = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.mes),
                    datasets: [
                        {
                            label: 'Completadas',
                            data: data.map(d => d.completadas),
                            borderColor: '#10b981',
                            backgroundColor: '#10b98122',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 2
                        },
                        {
                            label: 'Ausentes',
                            data: data.map(d => d.ausentes),
                            borderColor: '#f43f5e',
                            backgroundColor: 'transparent',
                            borderDash: [5, 5],
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#f43f5e',
                            pointBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Inter', size: 13, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 12,
                            cornerRadius: 12
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush