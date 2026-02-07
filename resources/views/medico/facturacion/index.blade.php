@extends('layouts.medico')

@section('title', 'Mis Facturas')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Mis Facturas</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Gestión de facturas generadas por tus servicios</p>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline" disabled title="Próximamente">
                <i class="bi bi-download mr-2"></i>
                Exportar Reporte
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total Facturado -->
        <div class="card p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border-blue-200 dark:border-blue-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-none">
                    <i class="bi bi-receipt text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wide">Total Facturado</p>
                    <p class="text-2xl font-bold text-blue-900 dark:text-white">${{ number_format($stats['total_facturado'] ?? 0, 2) }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">{{ $stats['facturas_totales'] ?? 0 }} facturas</p>
                </div>
            </div>
        </div>

        <!-- Liquidado (Pagado al médico) -->
        <div class="card p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border-emerald-200 dark:border-emerald-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none">
                    <i class="bi bi-wallet2 text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300 uppercase tracking-wide">Pagado</p>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-white">${{ number_format($stats['total_liquidado'] ?? 0, 2) }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['facturas_liquidadas'] ?? 0 }} liquidadas</p>
                </div>
            </div>
        </div>

        <!-- Pendiente de Liquidación -->
        <div class="card p-6 bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 border-amber-200 dark:border-amber-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200 dark:shadow-none">
                    <i class="bi bi-hourglass-split text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-amber-700 dark:text-amber-300 uppercase tracking-wide">Pendiente Pago</p>
                    <p class="text-2xl font-bold text-amber-900 dark:text-white">${{ number_format($stats['total_pendiente'] ?? 0, 2) }}</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">{{ $stats['facturas_pendientes'] ?? 0 }} facturas</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="card bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Fecha</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Nro Control</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Paciente</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Descripción</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center">Monto</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($facturas as $factura)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y') }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($factura->created_at)->format('h:i A') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="badge bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200 dark:border-amber-800 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $factura->cabecera->nro_control ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(optional($factura->cabecera->cita)->paciente->primer_nombre ?? 'P', 0, 1) }}{{ substr(optional($factura->cabecera->cita)->paciente->primer_apellido ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ optional($factura->cabecera->cita)->paciente->nombre_completo ?? 'Paciente Eliminado' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ optional($factura->cabecera->cita)->paciente->numero_documento ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ optional($factura->cabecera->cita)->especialidad->nombre ?? 'Consulta General' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($factura->estado_liquidacion == 'Liquidado')
                                <span class="badge bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="bi bi-check-circle-fill mr-1"></i> PAGADO
                                </span>
                            @else
                                <span class="badge bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800 px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="bi bi-clock-fill mr-1"></i> PENDIENTE
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900 dark:text-white block">
                                ${{ number_format($factura->total_final_usd, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('medico.facturacion.show', $factura->id) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-colors" 
                               title="Ver Detalle">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-receipt text-3xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No tienes facturas registradas</h3>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($facturas->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            {{ $facturas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
