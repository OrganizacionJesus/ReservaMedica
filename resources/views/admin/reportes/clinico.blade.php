@extends('layouts.admin')

@section('title', 'Estadísticas Clínicas')

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
                            <span class="text-sm font-bold text-gray-900 dark:text-white ml-1">Estadísticas Clínicas</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Filters and Export Row -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <form action="{{ route('reportes.clinico') }}" method="GET" class="flex flex-wrap items-center gap-3">
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
                <a href="{{ route('reportes.export', array_merge(['type' => 'pdf', 'report' => 'clinico', 'start_date' => $startDate, 'end_date' => $endDate], request()->only(['consultorio_id', 'ciudad_id']))) }}"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all flex items-center gap-2 w-fit">
                    <i class="bi bi-file-earmark-pdf text-rose-500"></i> Exportar PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Diagnósticos -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="bi bi-clipboard2-pulse text-purple-500"></i> Principales Diagnósticos
                </h4>
                <div class="space-y-4">
                    @forelse($topDiagnosticos as $diagnostico)
                        <div
                            class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 hover:bg-purple-50 dark:hover:bg-purple-900/10 transition-colors group">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black text-sm group-hover:scale-110 transition-transform">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $diagnostico->diagnostico }}</p>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">
                                    {{ $diagnostico->total }} CASOS REGISTRADOS</p>
                            </div>
                            <i class="bi bi-chevron-right text-gray-300"></i>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm italic">No hay diagnósticos suficientes para el periodo.</p>
                    @endforelse
                </div>
            </div>

            <!-- Demografía y Género -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-2">
                    <i class="bi bi-people text-blue-500"></i> Distribución por Género
                </h4>

                <div class="flex flex-col items-center justify-center gap-8">
                    <!-- Género Legend & Stats -->
                    <div class="grid grid-cols-2 gap-8 w-full">
                        @php
                            $totalPacientes = $demografiaGenero->sum('total');
                        @endphp
                        @foreach($demografiaGenero as $gen)
                            <div
                                class="p-6 rounded-3xl {{ $gen->genero == 'Masculino' ? 'bg-blue-50 dark:bg-blue-900/10' : 'bg-rose-50 dark:bg-rose-900/10' }} flex flex-col items-center text-center">
                                <div
                                    class="w-12 h-12 rounded-2xl {{ $gen->genero == 'Masculino' ? 'bg-blue-500' : 'bg-rose-500' }} text-white flex items-center justify-center shadow-lg mb-4">
                                    <i class="bi bi-gender-{{ strtolower($gen->genero) }} text-2xl"></i>
                                </div>
                                <p
                                    class="text-xs font-bold {{ $gen->genero == 'Masculino' ? 'text-blue-600' : 'text-rose-600' }} uppercase tracking-widest">
                                    {{ $gen->genero }}</p>
                                <h5 class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ $gen->total }}</h5>
                                <p class="text-xs font-medium text-gray-500 mt-1">
                                    {{ $totalPacientes > 0 ? round(($gen->total / $totalPacientes) * 100, 1) : 0 }}% del total
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tip Visual -->
                    <div
                        class="w-full p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/20 rounded-2xl flex items-start gap-3">
                        <i class="bi bi-lightbulb-fill text-amber-500 mt-0.5"></i>
                        <p class="text-xs text-amber-800 dark:text-amber-400 font-medium">
                            <strong>Insight:</strong> La mayoría de las consultas en este periodo han sido realizadas por
                            pacientes del género
                            {{ $demografiaGenero->sortByDesc('total')->first()->genero ?? 'N/D' }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection