@extends('layouts.admin')

@section('title', 'Reportes Financieros')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="space-y-4">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('reportes.index') }}"
                            class="text-sm font-medium text-gray-500 hover:text-medical-600 flex items-center gap-1 transition-colors">
                            <i class="bi bi-graph-up-arrow"></i> Reportes
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="bi bi-chevron-right text-gray-400 text-xs mx-1"></i>
                            <span class="text-sm font-bold text-gray-900 dark:text-white ml-1">Análisis Financiero</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Filters and Export Row -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <form action="{{ route('reportes.financiero') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <!-- Date Filter -->
                    <div
                        class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-xl">
                        <i class="bi bi-calendar3 text-gray-500 text-sm"></i>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="bg-transparent border-none text-gray-700 dark:text-gray-300 text-sm focus:ring-0 w-32">
                        <span class="text-gray-400">-</span>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="bg-transparent border-none text-gray-700 dark:text-gray-300 text-sm focus:ring-0 w-32">
                    </div>

                    @if($isRoot)
                        <!-- City Filter -->
                        <div
                            class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-xl">
                            <i class="bi bi-geo-alt text-gray-500 text-sm"></i>
                            <select name="ciudad_id" onchange="this.form.submit()"
                                class="bg-transparent border-none text-gray-700 dark:text-gray-300 text-sm focus:ring-0 pr-8">
                                <option value="">Todas las ciudades</option>
                                @php
                                    $allCiudades = \App\Models\Ciudad::orderBy('ciudad')->get();
                                @endphp
                                @foreach($allCiudades as $ciudad)
                                    <option value="{{ $ciudad->id_ciudad }}" {{ request('ciudad_id') == $ciudad->id_ciudad ? 'selected' : '' }}>
                                        {{ $ciudad->ciudad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Consultorio Filter -->
                        <div
                            class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-xl">
                            <i class="bi bi-building text-gray-500 text-sm"></i>
                            <select name="consultorio_id"
                                class="bg-transparent border-none text-gray-700 dark:text-gray-300 text-sm focus:ring-0 pr-8">
                                <option value="">Todos los consultorios</option>
                                @php
                                    $query = \App\Models\Consultorio::where('status', 1);
                                    if (request('ciudad_id')) {
                                        $query->where('ciudad_id', request('ciudad_id'));
                                    }
                                    $consultorios = $query->get();
                                @endphp
                                @foreach($consultorios as $cons)
                                    <option value="{{ $cons->id }}" {{ request('consultorio_id') == $cons->id ? 'selected' : '' }}>
                                        {{ $cons->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <button type="submit"
                        class="bg-medical-500 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-medical-600 transition flex items-center gap-2">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </form>

                <!-- PDF Export -->
                <a href="{{ route('reportes.export', array_merge(['type' => 'pdf', 'report' => 'financiero', 'start_date' => $startDate, 'end_date' => $endDate], request()->only(['consultorio_id', 'ciudad_id']))) }}"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all flex items-center gap-2 w-fit">
                    <i class="bi bi-file-earmark-pdf text-rose-500"></i> Exportar PDF
                </a>
            </div>
        </div>

        <!-- Financial KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Ingresos Totales (USD)</p>
                    <h3 class="text-3xl font-black mt-2">${{ number_format($ingresosTotal, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2 text-xs font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                        <i class="bi bi-graph-up"></i> +12% vs mes anterior
                    </div>
                </div>
                <i class="bi bi-cash-coin absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
            </div>

            <div
                class="bg-gradient-to-br from-rose-500 to-orange-600 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Cuentas por Cobrar</p>
                    <h3 class="text-3xl font-black mt-2">${{ number_format($cuentasPorCobrar, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2 text-xs font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                        <i class="bi bi-clock-history"></i> Pendientes de pago
                    </div>
                </div>
                <i class="bi bi-receipt absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
            </div>

            <div
                class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative">
                <div class="relative z-10">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Ticket Promedio</p>
                    <h3 class="text-3xl font-black mt-2">
                        ${{ $totalFacturas > 0 ? number_format($ingresosTotal / $totalFacturas, 2) : '0.00' }}</h3>
                    <div class="mt-4 flex items-center gap-2 text-xs font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                        <i class="bi bi-person-check"></i> Por paciente atendido
                    </div>
                </div>
                <i class="bi bi-wallet2 absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Ingresos por Método de Pago -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-2">
                    <i class="bi bi-credit-card text-emerald-500"></i> Métodos de Pago
                </h4>
                <div class="space-y-6">
                    @forelse($metodosPago as $metodo)
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center text-gray-600 dark:text-gray-400">
                                <i
                                    class="bi bi-{{ $metodo->metodo_pago == 'Transferencia' ? 'bank' : ($metodo->metodo_pago == 'Efectivo' ? 'cash' : 'phone-fill') }} text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between mb-1">
                                    <span
                                        class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $metodo->metodo_pago }}</span>
                                    <span
                                        class="text-sm font-black text-gray-900 dark:text-white">${{ number_format($metodo->total, 2) }}</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full"
                                        style="width: {{ ($metodo->total / max(1, $ingresosTotal)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm italic">No hay datos para el periodo seleccionado.</p>
                    @endforelse
                </div>
            </div>

            <!-- Ingresos por Consultorio -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-2">
                    <i class="bi bi-building-up text-blue-500"></i> Rentabilidad por Consultorio
                </h4>
                <div class="space-y-6">
                    @forelse($ingresosConsultorio as $consultorio)
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <i class="bi bi-geo-alt-fill text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between mb-1">
                                    <span
                                        class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $consultorio->nombre }}</span>
                                    <span
                                        class="text-sm font-black text-gray-900 dark:text-white">${{ number_format($consultorio->total, 2) }}</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full"
                                        style="width: {{ ($consultorio->total / max(1, $ingresosTotal)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm italic">No hay datos por consultorio.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection