@extends('layouts.admin')

@section('title', 'Facturación')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900">Gestión de Facturación</h1>
            <p class="text-gray-600 mt-1">Administra facturas y cobros</p>
        </div>
        <a href="{{ route('facturacion.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Nueva Factura</span>
        </a>
    </div>

    {{-- Tabs --}}
    <div class="card p-2">
        <div class="flex gap-2">
            <a href="{{ route('facturacion.index', ['tipo' => 'pacientes']) }}" 
               class="flex-1 px-6 py-3 rounded-lg text-center font-semibold transition-all {{ ($tipo ?? 'pacientes') === 'pacientes' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="bi bi-person-fill mr-2"></i>
                Facturas de Pacientes
            </a>
            <a href="{{ route('facturacion.index', ['tipo' => 'internas', 'entidad' => 'Medico']) }}" 
               class="flex-1 px-6 py-3 rounded-lg text-center font-semibold transition-all {{ ($tipo ?? 'pacientes') === 'internas' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="bi bi-pie-chart-fill mr-2"></i>
                Facturas por Entidad
            </a>
        </div>
    </div>

    @if(($tipo ?? 'pacientes') === 'pacientes')
        {{-- FACTURAS DE PACIENTES --}}
        
        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="card p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 border-emerald-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-check-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-emerald-700">Cobradas</p>
                        <p class="text-2xl font-bold text-emerald-900">${{ number_format($stats['cobradas'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-gradient-to-br from-amber-50 to-amber-100 border-amber-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-clock-history text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-amber-700">Pendientes</p>
                        <p class="text-2xl font-bold text-amber-900">${{ number_format($stats['pendientes'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-gradient-to-br from-rose-50 to-rose-100 border-rose-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-rose-700">Vencidas</p>
                        <p class="text-2xl font-bold text-rose-900">${{ number_format($stats['vencidas'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-receipt text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-blue-700">Total Facturas</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table - Patient Invoices --}}
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="w-32">Número</th>
                            <th>Paciente</th>
                            <th>Concepto</th>
                            <th class="w-32">Fecha</th>
                            <th class="w-32">Monto</th>
                            <th class="w-24">Estado</th>
                            <th class="w-40">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas ?? [] as $factura)
                        <tr>
                            <td>
                                <span class="font-mono text-sm font-semibold text-gray-900">{{ $factura->numero_factura ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-person text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ optional($factura->cita)->paciente->nombre_completo ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ optional($factura->cita)->paciente->numero_documento ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-700">Consulta médica - {{ optional($factura->cita->especialidad)->nombre ?? 'General' }}</span>
                            </td>
                            <td>
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="font-bold text-gray-900">${{ number_format($factura->monto_usd ?? 0, 2) }}</span>
                            </td>
                            <td>
                                @if($factura->status_factura == 'Pagada')
                                <span class="badge badge-success">Pagada</span>
                                @elseif($factura->status_factura == 'Emitida')
                                <span class="badge badge-warning">Pendiente</span>
                                @elseif($factura->status_factura == 'Vencida')
                                <span class="badge badge-danger">Vencida</span>
                                @else
                                <span class="badge badge-secondary">Cancelada</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('facturacion.show', $factura->id) }}" class="btn btn-sm btn-outline" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($factura->status_factura != 'Pagada')
                                    <a href="{{ route('facturacion.edit', $factura->id) }}" class="btn btn-sm btn-outline" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('facturacion.show', $factura->id) }}?format=pdf" class="btn btn-sm btn-outline text-rose-600" title="PDF">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <i class="bi bi-inbox text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No se encontraron facturas</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($facturas) && $facturas->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $facturas->links() }}
            </div>
            @endif
        </div>

    @else
        {{-- FACTURAS INTERNAS (POR ENTIDAD) --}}
        
        {{-- Selector de Entidad --}}
        <div class="card p-6">
            <div class="flex items-center gap-4">
                <label class="text-sm font-semibold text-gray-700 whitespace-nowrap">Filtrar por Entidad:</label>
                <div class="flex gap-2 flex-1">
                    <a href="{{ route('facturacion.index', ['tipo' => 'internas', 'entidad' => 'Medico']) }}" 
                       class="flex-1 px-4 py-2 rounded-lg text-center font-semibold transition-all {{ ($entidadTipo ?? 'Medico') === 'Medico' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <i class="bi bi-person-badge mr-2"></i>Médicos
                    </a>
                    <a href="{{ route('facturacion.index', ['tipo' => 'internas', 'entidad' => 'Consultorio']) }}" 
                       class="flex-1 px-4 py-2 rounded-lg text-center font-semibold transition-all {{ ($entidadTipo ?? 'Medico') === 'Consultorio' ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <i class="bi bi-hospital mr-2"></i>Consultorios
                    </a>
                    <a href="{{ route('facturacion.index', ['tipo' => 'internas', 'entidad' => 'Sistema']) }}" 
                       class="flex-1 px-4 py-2 rounded-lg text-center font-semibold transition-all {{ ($entidadTipo ?? 'Medico') === 'Sistema' ? 'bg-violet-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <i class="bi bi-gear mr-2"></i>Sistema
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-person-badge text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-blue-700">Facturas Médicos</p>
                        <p class="text-2xl font-bold text-blue-900">${{ number_format($stats['total_medico'] ?? 0, 2) }}</p>
                        <p class="text-xs text-blue-600">{{ $stats['count_medico'] ?? 0 }} facturas</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 border-emerald-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-hospital text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-emerald-700">Facturas Consultorios</p>
                        <p class="text-2xl font-bold text-emerald-900">${{ number_format($stats['total_consultorio'] ?? 0, 2) }}</p>
                        <p class="text-xs text-emerald-600">{{ $stats['count_consultorio'] ?? 0 }} facturas</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-gradient-to-br from-violet-50 to-violet-100 border-violet-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-violet-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-gear text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-violet-700">Facturas Sistema</p>
                        <p class="text-2xl font-bold text-violet-900">${{ number_format($stats['total_sistema'] ?? 0, 2) }}</p>
                        <p class="text-xs text-violet-600">{{ $stats['count_sistema'] ?? 0 }} facturas</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table - Entity Invoices --}}
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="w-32">Nro. Control</th>
                            <th>Paciente</th>
                            <th>
                                @if(($entidadTipo ?? 'Medico') === 'Medico')
                                    Médico
                                @elseif(($entidadTipo ?? 'Medico') === 'Consultorio')
                                    Consultorio
                                @else
                                    Entidad
                                @endif
                            </th>
                            <th>Especialidad</th>
                            <th class="text-right w-32">Total</th>
                            <th class="w-24">Estado</th>
                            <th class="w-32">Fecha</th>
                            <th class="w-32">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas ?? [] as $facturaTotal)
                        <tr>
                            <td>
                                <span class="font-mono text-sm font-semibold text-gray-900">{{ $facturaTotal->cabecera->nro_control ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-person text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ optional($facturaTotal->cabecera->cita)->paciente->nombre_completo ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ optional($facturaTotal->cabecera->cita)->paciente->numero_documento ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(($entidadTipo ?? 'Medico') === 'Medico')
                                    <span class="text-gray-700">
                                        Dr. {{ optional($facturaTotal->cabecera->cita)->medico->primer_nombre ?? '' }} 
                                        {{ optional($facturaTotal->cabecera->cita)->medico->primer_apellido ?? '' }}
                                    </span>
                                @elseif(($entidadTipo ?? 'Medico') === 'Consultorio')
                                    <span class="text-gray-700">{{ optional($facturaTotal->cabecera->cita)->consultorio->nombre ?? 'N/A' }}</span>
                                @else
                                    <span class="text-gray-700">Sistema General</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-gray-700">{{ optional($facturaTotal->cabecera->cita->especialidad)->nombre ?? 'General' }}</span>
                            </td>
                            <td class="text-right">
                                <span class="font-bold text-gray-900">${{ number_format($facturaTotal->total_final_usd ?? 0, 2) }}</span>
                            </td>
                            <td>
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $facturaTotal->estado_liquidacion == 'Liquidado' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $facturaTotal->estado_liquidacion ?? 'Pendiente' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($facturaTotal->cabecera->fecha_emision)->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('facturacion.show', $facturaTotal->id) }}?tipo=interna" 
                                       class="btn btn-sm btn-outline" 
                                       title="Ver Detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-12">
                                <i class="bi bi-inbox text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No se encontraron facturas de {{ $entidadTipo ?? 'Médicos' }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($facturas) && $facturas->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $facturas->appends(['tipo' => 'internas', 'entidad' => $entidadTipo])->links() }}
            </div>
            @endif
        </div>
    @endif
</div>
@endsection
