@extends('layouts.admin')

@section('title', 'Detalle de Factura')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('facturacion.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900">Factura #{{ $factura->numero_factura ?? 'N/A' }}</h1>
                <p class="text-gray-600 mt-1">Detalle completo de la factura</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('facturacion.show', $factura->id) }}?format=pdf" class="btn btn-primary">
                <i class="bi bi-file-pdf"></i> Descargar PDF
            </a>
            @if($factura->status_factura != 'Pagada')
            <a href="{{ route('facturacion.edit', $factura->id) }}" class="btn btn-outline">
                <i class="bi bi-pencil"></i> Editar
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Invoice Document -->
            <div class="card p-8">
                <!-- Header -->
                <div class="flex justify-between items-start mb-8 pb-8 border-b-2 border-gray-200">
                    <div>
                        <h2 class="text-3xl font-display font-bold text-gray-900 mb-2">FACTURA</h2>
                        <p class="text-gray-600">Sistema de Reservas Médicas</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Número de Factura</p>
                        <p class="text-2xl font-bold text-gray-900">#{{ $factura->numero_factura ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 mt-2">Fecha: {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Patient/Representative Info -->
                <div class="mb-8">
                    @php
                        // Determine who is the client/payer (Representative or Patient)
                        $cliente = $factura->cita->representante ?? $factura->paciente;
                        $esRepresentante = (bool) $factura->cita->representante;
                        
                        // Construct Data safely
                        $nombre = ($cliente->primer_nombre ?? '') . ' ' . ($cliente->primer_apellido ?? '');
                        $cedula = ($cliente->tipo_documento ?? '') . '-' . ($cliente->numero_documento ?? '');
                        $telefono = ($cliente->prefijo_tlf ?? '') . '-' . ($cliente->numero_tlf ?? '');
                        
                        // Email logic: distinct for Patient vs Representative
                        $email = 'N/A';
                        if ($cliente instanceof \App\Models\Paciente) {
                            $email = optional($cliente->usuario)->correo ?? 'N/A';
                        } elseif ($cliente instanceof \App\Models\Representante) {
                             $email = optional($cliente->usuario)->correo ?? 'N/A';
                        }
                    @endphp

                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">{{ $esRepresentante ? 'Responsable / Representante' : 'Paciente' }}</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-bold text-gray-900 text-lg">{{ $nombre ?: 'N/A' }}</p>
                        <p class="text-gray-600 mt-1">Cédula: {{ $cedula != '-' ? $cedula : 'N/A' }}</p>
                        <p class="text-gray-600">Teléfono: {{ $telefono != '-' ? $telefono : 'N/A' }}</p>
                        <p class="text-gray-600">Email: {{ $email }}</p>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Detalle</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-300">
                                    <th class="text-left py-3 text-gray-700 font-semibold">Concepto</th>
                                    <th class="text-right py-3 text-gray-700 font-semibold">Cantidad</th>
                                    <th class="text-right py-3 text-gray-700 font-semibold">Precio</th>
                                    <th class="text-right py-3 text-gray-700 font-semibold">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="py-4">
                                        <p class="font-semibold text-gray-900">Consulta Médica</p>
                                        <p class="text-sm text-gray-500">{{ optional($factura->cita->especialidad)->nombre ?? 'General' }}</p>
                                    </td>
                                    <td class="text-right text-gray-700">1</td>
                                    <td class="text-right text-gray-700">${{ number_format($factura->monto_usd ?? 0, 2) }}</td>
                                    <td class="text-right font-bold text-gray-900">${{ number_format($factura->monto_usd ?? 0, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-64 space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span>${{ number_format($factura->monto_usd ?? 0, 2) }}</span>
                        </div>
                        @if($factura->descuento > 0)
                        <div class="flex justify-between text-gray-700">
                            <span>Descuento ({{ $factura->descuento }}%):</span>
                            <span class="text-rose-600">-${{ number_format(($factura->monto_usd * $factura->descuento / 100) ?? 0, 2) }}</span>
                        </div>
                        @endif
                        @if($factura->iva > 0)
                        <div class="flex justify-between text-gray-700">
                            <span>IVA ({{ $factura->iva }}%):</span>
                            <span>${{ number_format((($factura->monto_usd - ($factura->monto_usd * $factura->descuento / 100)) * $factura->iva / 100) ?? 0, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between pt-3 border-t-2 border-gray-300">
                            <span class="text-lg font-bold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold text-emerald-700">${{ number_format($factura->monto_usd ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($factura->notas)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600"><strong>Notas:</strong> {{ $factura->notas }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
@php
    $ultimoPago = $factura->pagos->where('estado', 'Confirmado')->sortByDesc('created_at')->first();
@endphp

            <!-- Status -->
            <div class="card p-6">
                <h3 class="text-lg font-display font-bold text-gray-900 mb-4">Estado</h3>
                <div class="text-center">
                    @if($factura->status_factura == 'Pagada')
                    <div class="w-20 h-20 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-3">
                        <i class="bi bi-check-circle text-emerald-600 text-4xl"></i>
                    </div>
                    <p class="text-xl font-bold text-emerald-700">Pagada</p>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $ultimoPago ? \Carbon\Carbon::parse($ultimoPago->fecha_pago)->format('d/m/Y') : 'Fecha no registrada' }}
                    </p>
                    @elseif($factura->status_factura == 'Emitida')
                    <div class="w-20 h-20 mx-auto rounded-full bg-amber-100 flex items-center justify-center mb-3">
                        <i class="bi bi-clock-history text-amber-600 text-4xl"></i>
                    </div>
                    <p class="text-xl font-bold text-amber-700">Pendiente</p>
                    @elseif($factura->status_factura == 'Vencida')
                    <div class="w-20 h-20 mx-auto rounded-full bg-rose-100 flex items-center justify-center mb-3">
                        <i class="bi bi-exclamation-triangle text-rose-600 text-4xl"></i>
                    </div>
                    <p class="text-xl font-bold text-rose-700">Vencida</p>
                    @else
                    <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-3">
                        <i class="bi bi-x-circle text-gray-600 text-4xl"></i>
                    </div>
                    <p class="text-xl font-bold text-gray-700">Cancelada</p>
                    @endif
                </div>

                @if($factura->status_factura != 'Pagada' && $factura->status_factura != 'Cancelada')
                <div class="mt-6">
                    <a href="{{ route('pagos.create') }}?factura_id={{ $factura->id }}" class="btn btn-success w-full">
                        <i class="bi bi-cash"></i> Registrar Pago
                    </a>
                </div>
                @endif
            </div>

            <!-- Info -->
            <div class="card p-6">
                <h3 class="text-lg font-display font-bold text-gray-900 mb-4">Información</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Fecha Emisión</span>
                        <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</span>
                    </div>
                    @if($factura->fecha_vencimiento)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Vencimiento</span>
                        <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($factura->fecha_vencimiento)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Método de Pago</span>
                        <span class="font-semibold text-gray-900">
                            {{ $ultimoPago && $ultimoPago->metodoPago ? $ultimoPago->metodoPago->nombre : 'Pendiente' }}
                        </span>
                    </div>
                </div>
            </div>

            @if(auth()->user()->administrador && $factura->cita->facturaCabecera)
            <!-- Distribución (Solo Admin) -->
            <div class="card p-6 mt-6">
                <h3 class="text-lg font-display font-bold text-gray-900 mb-4">Distribución de Ingresos</h3>
                <div class="space-y-3 text-sm">
                    @foreach($factura->cita->facturaCabecera->detalles as $detalle)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-900">{{ $detalle->entidad_tipo }}</span>
                            <span class="text-xs text-gray-500">{{ $detalle->descripcion }}</span>
                        </div>
                        <span class="font-bold text-emerald-700">${{ number_format($detalle->subtotal_usd, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card p-6">
                <h3 class="text-lg font-display font-bold text-gray-900 mb-4">Acciones</h3>
                <div class="space-y-2">
                    <a href="{{ route('facturacion.show', $factura->id) }}?format=pdf" class="btn btn-outline w-full justify-start">
                        <i class="bi bi-file-pdf"></i> Descargar PDF
                    </a>
                    <a href="#" onclick="window.open('{{ route('facturacion.show', $factura->id) }}?format=pdf&email=true', '_blank')" class="btn btn-outline w-full justify-start">
                        <i class="bi bi-envelope"></i> Enviar por Email
                    </a>
                    <button onclick="window.print()" class="btn btn-outline w-full justify-start">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
