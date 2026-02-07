@extends('layouts.admin')

@section('title', 'Nueva Factura')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900">Confirmar Pagos Pendientes</h1>
            <p class="text-gray-600 mt-1">Revise y confirme los pagos de las citas médicas</p>
        </div>
        <a href="{{ route('facturacion.index') }}" class="btn btn-outline">
            <i class="bi bi-list"></i> Ver Todas las Facturas
        </a>
    </div>

    <!-- Lista de Facturas con Pagos Pendientes -->
    <div class="space-y-4">
        @forelse($facturas ?? [] as $factura)
        <div class="card p-6 shadow-sm border-gray-100 hover:shadow-md transition-shadow">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Información de la Cita -->
                <div class="lg:col-span-2">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-calendar-check text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2">
                                Factura #{{ $factura->numero_factura ?? 'F-' . str_pad($factura->id, 6, '0', STR_PAD_LEFT) }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Paciente:</p>
                                    <p class="font-semibold">{{ optional($factura->cita->paciente)->nombre_completo ?? 'N/A' }}</p>
                                    <p class="text-gray-600">C.I: {{ optional($factura->cita->paciente)->cedula ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Servicio:</p>
                                    <p class="font-semibold">{{ optional($factura->cita->medico)->primer_nombre }} {{ optional($factura->cita->medico)->primer_apellido }}</p>
                                    <p class="text-gray-600">{{ optional($factura->cita->especialidad)->nombre ?? 'General' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Fecha y Hora:</p>
                                    <p class="font-semibold">{{ \Carbon\Carbon::parse($factura->cita->fecha_cita)->format('d/m/Y H:i') }}</p>
                                    <p class="text-gray-600">{{ optional($factura->cita->consultorio)->nombre ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Información de Pago:</p>
                                    <p class="font-semibold">${{ number_format(optional($factura->pagos->first())->monto_equivalente_usd ?? 0, 2) }}</p>
                                    <p class="text-gray-600">{{ optional(optional($factura->pagos->first())->metodoPago)->nombre ?? 'N/A' }}</p>
                                    <p class="text-gray-600">Ref: {{ optional($factura->pagos->first())->referencia ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="space-y-3">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-amber-100 flex items-center justify-center mb-3">
                            <i class="bi bi-clock-history text-amber-600 text-2xl"></i>
                        </div>
                        <p class="text-sm font-bold text-amber-700 mb-1">Pago Pendiente</p>
                        <p class="text-xs text-gray-600">Esperando confirmación</p>
                    </div>
                    
                    @if($factura->pagos->first())
                    <form action="{{ route('pagos.confirmar', $factura->pagos->first()->id_pago) }}" method="POST" class="space-y-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-full">
                            <i class="bi bi-check-circle"></i> Confirmar Pago
                        </button>
                    </form>
                    
                    <form action="{{ route('pagos.rechazar', $factura->pagos->first()->id_pago) }}" method="POST" class="space-y-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger w-full">
                            <i class="bi bi-x-circle"></i> Rechazar Pago
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <i class="bi bi-check-circle text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No hay pagos pendientes</h3>
            <p class="text-gray-600">Todos los pagos han sido procesados</p>
            <a href="{{ route('facturacion.index') }}" class="btn btn-primary mt-4">
                <i class="bi bi-list"></i> Ver Todas las Facturas
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
