@extends('layouts.medico')

@section('title', 'Detalle de Factura #' . ($facturaTotal->cabecera->nro_control ?? 'N/A'))

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('medico.facturacion.index') }}" class="btn btn-outline">
            <i class="bi bi-arrow-left"></i> Volver a Facturas
        </a>
        <div class="flex items-center gap-3">
            <span class="badge px-4 py-2 font-bold uppercase rounded-xl
                {{ $facturaTotal->estado_liquidacion == 'Liquidado' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' }}">
                <i class="bi {{ $facturaTotal->estado_liquidacion == 'Liquidado' ? 'bi-check-circle-fill' : 'bi-clock-fill' }} mr-2"></i>
                {{ $facturaTotal->estado_liquidacion }}
            </span>
        </div>
    </div>

    <div class="card bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        {{-- Header Section --}}
        <div class="p-8 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-white dark:from-blue-900/10 dark:to-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 dark:shadow-none">
                        <i class="bi bi-receipt text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Factura #{{ $facturaTotal->cabecera->nro_control ?? 'N/A' }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Emitida el {{ \Carbon\Carbon::parse($facturaTotal->created_at)->format('d \d\e F, Y \a \l\a\s h:i A') }}
                        </p>
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mt-2">
                           Entidad: Médico
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold">Total a Pagar</p>
                    <p class="text-4xl font-display font-black text-gray-900 dark:text-white mt-1">
                        ${{ number_format($facturaTotal->total_final_usd, 2) }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Bs. {{ number_format($facturaTotal->total_final_bs, 2) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                        Información del Cliente
                    </h3>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <i class="bi bi-person-badge text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white text-lg">
                                Dr. {{ optional($facturaTotal->medico)->primer_nombre }} {{ optional($facturaTotal->medico)->primer_apellido }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ optional(optional(optional($facturaTotal->cabecera)->cita)->especialidad)->nombre ?? 'Sin Especialidad' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                        Origen del Ingreso
                    </h3>
                    @if($facturaTotal->entidad_tipo == 'Medico')
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="bi bi-person-heart text-blue-600 dark:text-blue-400 text-lg"></i>
                                <span class="font-bold text-gray-900 dark:text-white">Consulta Médica</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <strong>Paciente:</strong> {{ optional($facturaTotal->cabecera->cita)->paciente->nombre_completo }}<br>
                                <strong>Fecha Cita:</strong> {{ \Carbon\Carbon::parse(optional($facturaTotal->cabecera->cita)->fecha_hora)->format('d/m/Y h:i A') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Breakdown Table --}}
        <div class="border-t border-gray-100 dark:border-gray-700">
            <div class="p-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Detalle de Cargos</h3>
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Concepto</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">Referencia</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Monto Unitario</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Cantidad</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($facturaTotal->liquidacionDetalles as $detalle)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        Honorarios Médicos - {{ optional($facturaTotal->cabecera->cita)->especialidad->nombre }}
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $detalle->descripcion ?? 'Porcentaje correspondiente por servicio médico' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-600 dark:text-gray-300">
                                        {{ $detalle->facturaPaciente->numero_factura ?? 'REF-001' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600 dark:text-gray-300">
                                    ${{ number_format($detalle->monto, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600 dark:text-gray-300">
                                    1
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($detalle->monto, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-600 dark:text-gray-400">Subtotal</td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">${{ number_format($facturaTotal->base_imponible_usd, 2) }}</td>
                            </tr>
                            @if($facturaTotal->impuestos_usd > 0)
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-600 dark:text-gray-400">Impuestos</td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">${{ number_format($facturaTotal->impuestos_usd, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="bg-blue-600 text-white">
                                <td colspan="4" class="px-6 py-4 text-right font-black uppercase text-sm">Total Final</td>
                                <td class="px-6 py-4 text-right font-black text-lg">${{ number_format($facturaTotal->total_final_usd, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
