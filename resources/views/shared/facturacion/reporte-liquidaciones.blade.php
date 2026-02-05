@extends('layouts.admin')

@section('title', 'Reporte de Liquidaciones')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Reporte de Liquidaciones</h1>
            <p class="text-gray-600 mt-1">Análisis detallado de liquidaciones procesadas</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline">
            <i class="bi bi-printer mr-2"></i>
            <span>Imprimir Reporte</span>
        </button>
    </div>

    <!-- Filtros -->
    <div class="card p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="label"><span class="label-text font-bold">Período</span></label>
                <select name="periodo" class="select">
                    <option value="">Todos</option>
                    <option value="quincenal" {{ request('periodo') == 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                    <option value="mensual" {{ request('periodo') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                </select>
            </div>
            <div>
                <label class="label"><span class="label-text font-bold">Entidad</span></label>
                <select name="entidad" class="select">
                    <option value="">Todas</option>
                    <option value="Medico" {{ request('entidad') == 'Medico' ? 'selected' : '' }}>Médicos</option>
                    <option value="Consultorio" {{ request('entidad') == 'Consultorio' ? 'selected' : '' }}>Consultorios</option>
                </select>
            </div>
            <div>
                <label class="label"><span class="label-text font-bold">Desde</span></label>
                <input type="date" name="fecha_desde" class="input" value="{{ request('fecha_desde') }}">
            </div>
            <div>
                <label class="label"><span class="label-text font-bold">Hasta</span></label>
                <input type="date" name="fecha_hasta" class="input" value="{{ request('fecha_hasta') }}">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search mr-2"></i>
                    Filtrar
                </button>
                <a href="{{ route('facturacion.reporte-liquidaciones') }}" class="btn btn-outline">
                    <i class="bi bi-x-lg mr-2"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Resumen General -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                    <i class="bi bi-cash-stack text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-blue-700">Total Liquidado</p>
                    <p class="text-2xl font-bold text-blue-900">${{ number_format($resumen['total_usd'] ?? 0, 2) }}</p>
                    <p class="text-xs text-blue-600">Bs. {{ number_format($resumen['total_bs'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="card p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 border-emerald-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="bi bi-person-badge text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-emerald-700">Médicos</p>
                    <p class="text-2xl font-bold text-emerald-900">{{ $resumen['medicos_count'] ?? 0 }}</p>
                    <p class="text-xs text-emerald-600">Entidades</p>
                </div>
            </div>
        </div>

        <div class="card p-6 bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center">
                    <i class="bi bi-building text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-purple-700">Consultorios</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $resumen['consultorios_count'] ?? 0 }}</p>
                    <p class="text-xs text-purple-600">Entidades</p>
                </div>
            </div>
        </div>

        <div class="card p-6 bg-gradient-to-br from-amber-50 to-amber-100 border-amber-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center">
                    <i class="bi bi-receipt text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-amber-700">Liquidaciones</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $resumen['total_count'] ?? 0 }}</p>
                    <p class="text-xs text-amber-600">Procesadas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Liquidaciones por Entidad</h3>
            <div class="h-64">
                <canvas id="chartEntidades"></canvas>
            </div>
        </div>
        <div class="card p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tendencia Mensual</h3>
            <div class="h-64">
                <canvas id="chartTendencia"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabla de Detalles -->
    <div class="card">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Detalles de Liquidaciones</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>N° Liquidación</th>
                        <th>Entidad</th>
                        <th>Tipo</th>
                        <th>Período</th>
                        <th>Monto USD</th>
                        <th>Monto BS</th>
                        <th>Método Pago</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($liquidaciones ?? [] as $liquidacion)
                    <tr>
                        <td>
                            <span class="font-mono text-sm font-semibold">{{ $liquidacion->id }}</span>
                        </td>
                        <td>
                            @if($liquidacion->entidad_tipo == 'Medico' && $liquidacion->medico)
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-person-badge text-blue-600"></i>
                                    <span>{{ $liquidacion->medico->nombre_completo }}</span>
                                </div>
                            @elseif($liquidacion->entidad_tipo == 'Consultorio' && $liquidacion->consultorio)
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-building text-emerald-600"></i>
                                    <span>{{ $liquidacion->consultorio->nombre }}</span>
                                </div>
                            @else
                                <span class="text-gray-500">Desconocida</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $liquidacion->entidad_tipo }}</span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-600">{{ $liquidacion->periodo_tipo ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="text-right">
                                <div class="font-bold text-gray-900">${{ number_format($liquidacion->monto_total_usd, 2) }}</div>
                                <div class="text-sm text-gray-600">Bs. {{ number_format($liquidacion->monto_total_bs, 2) }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $liquidacion->metodo_pago == 'Pendiente' ? 'badge-warning' : 'badge-success' }}">
                                {{ $liquidacion->metodo_pago }}
                            </span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($liquidacion->fecha_pago)->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            <span class="badge badge-success">Procesada</span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <button onclick="verDetalleLiquidacion({{ $liquidacion->id }})" class="btn btn-sm btn-outline" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="{{ route('facturacion.detalle-liquidacion', $liquidacion->id) }}?format=pdf" class="btn btn-sm btn-outline text-rose-600" title="PDF">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-inbox text-6xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-medium">No hay liquidaciones para el período seleccionado</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de entidades
const ctxEntidades = document.getElementById('chartEntidades').getContext('2d');
new Chart(ctxEntidades, {
    type: 'doughnut',
    data: {
        labels: ['Médicos', 'Consultorios'],
        datasets: [{
            data: [{{ $resumen['medicos_total'] ?? 0 }}, {{ $resumen['consultorios_total'] ?? 0 }}],
            backgroundColor: ['#3b82f6', '#10b981']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Gráfico de tendencia
const ctxTendencia = document.getElementById('chartTendencia').getContext('2d');
new Chart(ctxTendencia, {
    type: 'line',
    data: {
        labels: @json($resumen['meses'] ?? []),
        datasets: [{
            label: 'Monto Liquidado (USD)',
            data: @json($resumen['montos_mensuales'] ?? []),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function verDetalleLiquidacion(id) {
    // Implementar vista de detalle
    Swal.fire('Detalle', 'Ver detalle de liquidación ' + id, 'info');
}
</script>
@endsection
