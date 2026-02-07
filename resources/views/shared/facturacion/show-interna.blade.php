@extends('layouts.admin')

@section('title', 'Detalle de Factura Interna')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900">Factura {{ $facturaSeleccionada->entidad_tipo }} - #{{ $facturaSeleccionada->cabecera->nro_control }}</h1>
            <p class="text-gray-600 mt-1">Detalles de la factura y facturas relacionadas de la misma cita</p>
        </div>
        <a href="{{ route('facturacion.index', ['tipo' => 'internas', 'entidad' => $facturaSeleccionada->entidad_tipo]) }}" class="btn btn-outline">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- Info General de la Cita --}}
    <div class="card p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Información de la Cita</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="text-sm font-semibold text-gray-700">Paciente</label>
                <p class="text-gray-900 font-semibold">{{ optional($facturaSeleccionada->cabecera->cita)->paciente->nombre_completo ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500">{{ optional($facturaSeleccionada->cabecera->cita)->paciente->numero_documento ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Médico</label>
                <p class="text-gray-900 font-semibold">Dr. {{ optional($facturaSeleccionada->cabecera->cita)->medico->primer_nombre ?? '' }} {{ optional($facturaSeleccionada->cabecera->cita)->medico->primer_apellido ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ optional($facturaSeleccionada->cabecera->cita)->especialidad->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Consultorio</label>
                <p class="text-gray-900 font-semibold">{{ optional($facturaSeleccionada->cabecera->cita)->consultorio->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Fecha Emisión</label>
                <p class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($facturaSeleccionada->cabecera->fecha_emision)->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Factura Seleccionada --}}
    @php
        $colores = [
            'Medico' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-300', 'text' => 'text-blue-900', 'icon-bg' => 'bg-blue-600', 'icon' => 'bi-person-badge-fill', 'badge' => 'bg-blue-100 text-blue-700'],
            'Consultorio' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-300', 'text' => 'text-emerald-900', 'icon-bg' => 'bg-emerald-600', 'icon' => 'bi-hospital-fill', 'badge' => 'bg-emerald-100 text-emerald-700'],
            'Sistema' => ['bg' => 'bg-violet-50', 'border' => 'border-violet-300', 'text' => 'text-violet-900', 'icon-bg' => 'bg-violet-600', 'icon' => 'bi-gear-fill', 'badge' => 'bg-violet-100 text-violet-700']
        ];
        $colorSeleccionada = $colores[$facturaSeleccionada->entidad_tipo] ?? $colores['Sistema'];
    @endphp

    <div class="card {{ $colorSeleccionada['bg'] }} border-2 {{ $colorSeleccionada['border'] }} p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <di class="w-14 h-14 {{ $colorSeleccionada['icon-bg'] }} rounded-xl flex items-center justify-center">
                    <i class="bi {{ $colorSeleccionada['icon'] }} text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold {{ $colorSeleccionada['text'] }}">Factura {{ $facturaSeleccionada->entidad_tipo }}</h3>
                    <p class="text-sm text-gray-600">Factura seleccionada</p>
                </div>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-bold {{ $colorSeleccionada['badge'] }}">
                SELECCIONADA
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="text-sm text-gray-600">Base Imponible</label>
                <p class="text-2xl font-bold {{ $colorSeleccionada['text'] }}">${{ number_format($facturaSeleccionada->base_imponible_usd, 2) }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-600">Impuestos</label>
                <p class="text-2xl font-bold {{ $colorSeleccionada['text'] }}">${{ number_format($facturaSeleccionada->impuestos_usd, 2) }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-600">Total Final</label>
                <p class="text-3xl font-bold {{ $colorSeleccionada['text'] }}">${{ number_format($facturaSeleccionada->total_final_usd, 2) }}</p>
                <p class="text-sm text-gray-600">Bs. {{ number_format($facturaSeleccionada->total_final_bs, 2) }}</p>
            </div>
        </div>

        @if($facturaSeleccionada->entidad_tipo == 'Medico' && $facturaSeleccionada->cabecera->cita->medico->datosPago)
        <div class="mt-6 pt-6 border-t border-blue-200">
            <h4 class="font-semibold text-blue-900 mb-3">Datos de Pago del Médico</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Banco:</span> 
                    <span class="font-semibold text-gray-900">{{ $facturaSeleccionada->cabecera->cita->medico->datosPago->banco }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Cuenta:</span> 
                    <span class="font-mono font-semibold text-gray-900">{{ $facturaSeleccionada->cabecera->cita->medico->datosPago->numero_cuenta }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Método:</span> 
                    <span class="font-semibold text-gray-900">{{ optional($facturaSeleccionada->cabecera->cita->medico->datosPago->metodoPago)->nombre ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Facturas Relacionadas --}}
    @if($facturasRelacionadas->count() > 0)
    <div class="card p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
            <i class="bi bi-diagram-3-fill text-gray-600 mr-2"></i>
            Facturas Relacionadas de la Misma Cita
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($facturasRelacionadas as $relacionada)
                @php
                    $colorRelacionada = $colores[$relacionada->entidad_tipo] ?? $colores['Sistema'];
                @endphp

                <div class="card {{ $colorRelacionada['bg'] }} border {{ $colorRelacionada['border'] }} p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 {{ $colorRelacionada['icon-bg'] }} rounded-lg flex items-center justify-center">
                                <i class="bi {{ $colorRelacionada['icon'] }} text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold {{ $colorRelacionada['text'] }}">{{ $relacionada->entidad_tipo }}</h4>
                                <p class="text-sm text-gray-600">
                                    @if($relacionada->entidad_tipo == 'Medico')
                                        Dr. {{ $facturaSeleccionada->cabecera->cita->medico->primer_nombre ?? '' }} {{ $facturaSeleccionada->cabecera->cita->medico->primer_apellido ?? '' }}
                                    @elseif($relacionada->entidad_tipo == 'Consultorio')
                                        {{ $facturaSeleccionada->cabecera->cita->consultorio->nombre ?? 'N/A' }}
                                    @else
                                        Sistema General
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Base Imponible:</span>
                            <span class="font-bold {{ $colorRelacionada['text'] }}">${{ number_format($relacionada->base_imponible_usd, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Impuestos:</span>
                            <span class="font-bold {{ $colorRelacionada['text'] }}">${{ number_format($relacionada->impuestos_usd, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-300">
                            <span class="text-sm font-semibold text-gray-700">Total Final:</span>
                            <span class="text-xl font-bold {{ $colorRelacionada['text'] }}">${{ number_format($relacionada->total_final_usd, 2) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-500">Bs. {{ number_format($relacionada->total_final_bs, 2) }}</span>
                        </div>
                    </div>

                    @if($relacionada->entidad_tipo == 'Medico' && $relacionada->cabecera->cita->medico->datosPago)
                    <div class="mt-4 pt-4 border-t border-blue-200">
                        <p class="text-xs font-semibold text-gray-700 mb-2">Datos de Pago</p>
                        <div class="text-xs text-gray-600 space-y-1">
                            <p><span class="font-semibold">Banco:</span> {{ $relacionada->cabecera->cita->medico->datosPago->banco }}</p>
                            <p><span class="font-semibold">Cuenta:</span> {{ $relacionada->cabecera->cita->medico->datosPago->numero_cuenta }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Factura del Paciente --}}
    @if($facturaPaciente)
    <div class="card p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i class="bi bi-receipt text-gray-600 mr-2"></i>
            Factura del Paciente (Relacionada)
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="text-sm text-gray-600">Número</label>
                <p class="font-mono font-bold text-gray-900">{{ $facturaPaciente->numero_factura }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-600">Monto USD</label>
                <p class="font-bold text-gray-900">${{ number_format($facturaPaciente->monto_usd, 2) }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-600">Monto Bs</label>
                <p class="font-bold text-gray-900">Bs. {{ number_format($facturaPaciente->monto_bs, 2) }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-600">Estado</label>
                @if($facturaPaciente->status_factura == 'Pagada')
                    <span class="badge badge-success">Pagada</span>
                @else
                    <span class="badge badge-warning">{{ $facturaPaciente->status_factura }}</span>
                @endif
            </div>
            <div class="flex items-end">
                <a href="{{ route('facturacion.show', $facturaPaciente->id) }}" class="btn btn-sm btn-outline">
                    <i class="bi bi-eye"></i> Ver Detalle
                </a>
            </div>
        </div>

        @if($facturaPaciente->pagos->count() > 0)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="font-semibold text-gray-900 mb-3">Pagos del Paciente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($facturaPaciente->pagos as $pago)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-cash-coin text-emerald-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">${{ number_format($pago->monto_equivalente_usd, 2) }}</p>
                            <p class="text-sm text-gray-600">{{ optional($pago->metodoPago)->nombre ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="badge {{ $pago->estado == 'Confirmado' ? 'badge-success' : 'badge-warning' }}">
                            {{ $pago->estado }}
                        </span>
                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Detalles de Facturación --}}
    @if($detalles->count() > 0)
    <div class="card p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i class="bi bi-list-ul text-gray-600 mr-2"></i>
            Detalles de Facturación (Todas las Entidades)
        </h3>
        
        <div class="overflow-x-auto">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Entidad</th>
                        <th>Descripción</th>
                        <th class="text-right">Cantidad</th>
                        <th class="text-right">Precio Unit.</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detalles as $detalle)
                    <tr>
                        <td>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $detalle->entidad_tipo == 'Medico' ? 'bg-blue-100 text-blue-700' : 
                                   ($detalle->entidad_tipo == 'Consultorio' ? 'bg-emerald-100 text-emerald-700' : 'bg-violet-100 text-violet-700') }}">
                                {{ $detalle->entidad_tipo }}
                            </span>
                        </td>
                        <td>{{ $detalle->descripcion }}</td>
                        <td class="text-right">{{ $detalle->cantidad }}</td>
                        <td class="text-right">${{ number_format($detalle->precio_unitario_usd, 2) }}</td>
                        <td class="text-right font-bold">${{ number_format($detalle->subtotal_usd, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
