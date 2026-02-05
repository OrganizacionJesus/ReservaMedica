@extends('layouts.admin')

@section('title', 'Reportes Operativos')

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
                            <span class="text-sm font-bold text-gray-900 dark:text-white ml-1">Operatividad</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Filters and Export Row -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <form action="{{ route('reportes.operatividad') }}" method="GET" class="flex flex-wrap items-center gap-3">
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
                <a href="{{ route('reportes.export', array_merge(['type' => 'pdf', 'report' => 'operatividad', 'start_date' => $startDate, 'end_date' => $endDate], request()->only(['consultorio_id', 'ciudad_id']))) }}"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all flex items-center gap-2 w-fit">
                    <i class="bi bi-file-earmark-pdf text-rose-500"></i> Exportar PDF
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <i class="bi bi-calendar-check text-2xl text-blue-600"></i>
                    </div>
                </div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Citas Programadas</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    {{ $ausentismoData->sum('total') }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <i class="bi bi-person-check text-2xl text-emerald-600"></i>
                    </div>
                </div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Consultorios Activos</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    {{ $ausentismoData->count() }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                        <i class="bi bi-person-x text-2xl text-rose-600"></i>
                    </div>
                </div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">No Show</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    {{ $ausentismoData->sum('ausentes') }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <i class="bi bi-percent text-2xl text-amber-600"></i>
                    </div>
                </div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Ausentismo</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    {{ $ausentismoData->sum('total') > 0 ? round(($ausentismoData->sum('ausentes') / $ausentismoData->sum('total')) * 100, 1) : 0 }}%
                </p>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Consultorio Occupancy -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="bi bi-building-check text-blue-500"></i> Ocupación por Consultorio
                </h4>
                <div class="space-y-6">
                    @forelse($ausentismoData as $item)
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm font-bold">
                                <span
                                    class="text-gray-700 dark:text-gray-300">{{ $item->consultorio->nombre ?? 'Sin nombre' }}</span>
                                <span
                                    class="text-blue-600">{{ $item->total > 0 ? round((($item->total - $item->ausentes) / $item->total) * 100, 1) : 0 }}%</span>
                            </div>
                            <div class="w-full h-3 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full"
                                    style="width: {{ $item->total > 0 ? round((($item->total - $item->ausentes) / $item->total) * 100, 1) : 0 }}%">
                                </div>
                            </div>
                            <div class="flex justify-between text-[10px] text-gray-500 font-medium mt-1">
                                <span>{{ $item->total }} citas programadas</span>
                                <span>{{ $item->ausentes }} ausencias</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No hay datos de consultorios para el periodo seleccionado</p>
                    @endforelse
                </div>
            </div>

            <!-- Doctor Productivity Table -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="bi bi-person-badge text-emerald-500"></i> Productividad por Médico
                </h4>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="py-4 px-2 text-xs font-bold text-gray-400 uppercase tracking-widest text-left">
                                    Médico</th>
                                <th class="py-4 px-2 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">
                                    Citas Totales</th>
                                <th class="py-4 px-2 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">
                                    Atendidas</th>
                                <th class="py-4 px-2 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">
                                    Evoluciones</th>
                                <th class="py-4 px-2 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">
                                    Eficiencia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                            @forelse($productividadMedicos as $medico)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-colors">
                                    <td class="py-4 px-2">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-medical-100 text-medical-600 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($medico->medico->nombre_completo ?? 'DR', 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                    {{ $medico->medico->nombre_completo ?? 'Sin nombre' }}
                                                </p>
                                                <p class="text-[10px] text-gray-500 font-medium">
                                                    {{ $medico->medico->especialidades->first()->nombre ?? 'Sin especialidad' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 text-center">
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-white">{{ $medico->total }}</span>
                                    </td>
                                    <td class="py-4 px-2 text-center">
                                        <span class="text-sm font-bold text-emerald-600">{{ $medico->atendidas }}</span>
                                    </td>
                                    <td class="py-4 px-2 text-center">
                                        <span
                                            class="text-sm font-bold text-blue-600">{{ $medico->medico->evolucionesClinicas->count() }}</span>
                                    </td>
                                    <td class="py-4 px-2 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                                                            {{ round(($medico->atendidas / max(1, $medico->total)) * 100) >= 70 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ round(($medico->atendidas / max(1, $medico->total)) * 100) }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">No hay datos de médicos para el
                                        periodo seleccionado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection