@extends('layouts.medico')

@section('title', 'Mis Métodos de Pago')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900">Mis Métodos de Pago</h1>
            <p class="text-gray-600 mt-1">Gestiona tus datos bancarios para recibir liquidaciones</p>
        </div>
        @if($datosPago)
        <a href="{{ route('medico.metodos-pago.edit') }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Editar Datos
        </a>
        @else
        <a href="{{ route('medico.metodos-pago.edit') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Registrar Métodos de Pago
        </a>
        @endif
    </div>

    @if(!$datosPago)
    {{-- No hay datos configurados --}}
    <div class="card p-12 text-center">
        <div class="w-24 h-24 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
            <i class="bi bi-credit-card text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No has configurado tus métodos de pago</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Para recibir liquidaciones, necesitas configurar al menos un método de pago con tus datos bancarios.
        </p>
        <a href="{{ route('medico.metodos-pago.edit') }}" class="btn btn-success inline-flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Configurar Ahora
        </a>
    </div>
    @else
    {{-- Datos configurados --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Datos bancarios --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                    <i class="bi bi-bank text-emerald-600 mr-2"></i>
                    Datos Bancarios
                </h3>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $datosPago->status ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                    {{ $datosPago->status ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="bi bi-building text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-gray-600">Banco</p>
                        <p class="font-semibold text-gray-900">{{ $datosPago->banco }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="bi bi-wallet2 text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-gray-600">Tipo de Cuenta</p>
                        <p class="font-semibold text-gray-900">{{ $datosPago->tipo_cuenta }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="bi bi-hash text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-gray-600">Número de Cuenta</p>
                        <p class="font-semibold text-gray-900 font-mono">{{ $datosPago->numero_cuenta }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="bi bi-person text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-gray-600">Titular</p>
                        <p class="font-semibold text-gray-900">{{ $datosPago->titular }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="bi bi-card-text text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-gray-600">Cédula</p>
                        <p class="font-semibold text-gray-900">{{ $datosPago->cedula }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información adicional --}}
        <div class="space-y-6">
            {{-- Método preferido --}}
            <div class="card p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-star-fill text-amber-500 mr-2"></i>
                    Método Preferido
                </h3>
                
                @if($datosPago->metodoPago)
                <div class="flex items-center p-4 bg-emerald-50 rounded-lg">
                    <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center text-white mr-4">
                        <i class="bi bi-check-circle-fill text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $datosPago->metodoPago->nombre }}</p>
                        <p class="text-sm text-gray-600">Preferido para recibir liquidaciones</p>
                    </div>
                </div>
                @else
                <p class="text-gray-500 text-sm">No has configurado un método preferido</p>
                @endif
            </div>

            {{-- Contacto --}}
            @if($datosPago->prefijo_tlf && $datosPago->numero_tlf)
            <div class="card p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-telephone text-blue-600 mr-2"></i>
                    Contacto
                </h3>
                
                <div class="flex items-start">
                    <i class="bi bi-phone text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-gray-600">Teléfono</p>
                        <p class="font-semibold text-gray-900">{{ $datosPago->telefono_completo }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Información --}}
            <div class="card p-6 bg-blue-50 border-blue-200">
                <div class="flex items-start">
                    <i class="bi bi-info-circle-fill text-blue-600 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-1">Información Importante</h4>
                        <p class="text-sm text-blue-800">
                            Estos datos serán utilizados por el administrador al generar tus liquidaciones quincenales o mensuales. 
                            Asegúrate de que la información sea correcta para evitar retrasos en los pagos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
