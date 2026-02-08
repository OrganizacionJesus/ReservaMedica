@extends('layouts.admin')

@section('title', 'Registrar Pago')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('pagos.index') }}" class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-display font-bold text-gray-900 leading-tight">Registrar Pago</h1>
                <p class="text-gray-600">Proceso de recaudación y auditoría de facturas</p>
            </div>
        </div>
    </div>

    <form action="{{ route('pagos.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        <!-- Main Form Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Factura -->
            <div class="card p-6 shadow-sm border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-2 -mr-2 w-24 h-24 bg-blue-50 rounded-full blur-3xl opacity-50"></div>

                <h3 class="text-lg font-display font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shadow-sm shadow-blue-200">
                        <i class="bi bi-receipt text-sm"></i>
                    </span>
                    Seleccionar Factura Pendiente
                </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label font-semibold text-gray-700 mb-1">Factura Pendiente</label>
                            <select name="id_factura_paciente" id="factura_id" class="form-select select2" required>
                                <option value="">Seleccionar factura...</option>
                                @foreach($facturas as $factura)
                                @php
                                    $totalPagado = $factura->pagos->where('estado', 'Confirmado')->sum('monto_equivalente_usd');
                                    $saldoPendiente = $factura->monto_usd - $totalPagado;
                                @endphp
                                <option value="{{ $factura->id }}" 
                                        data-monto-usd="{{ $saldoPendiente }}"
                                        data-paciente="{{ optional($factura->paciente)->nombre_completo ?? 'N/A' }}"
                                        data-cedula="{{ optional($factura->paciente)->cedula ?? 'N/A' }}"
                                        data-nro="{{ $factura->numero_factura }}"
                                        {{ request('factura_id') == $factura->id ? 'selected' : '' }}>
                                    {{ $factura->numero_factura }} - {{ optional($factura->paciente)->nombre_completo }} (Pendiente: ${{ number_format($saldoPendiente, 2) }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="facturaInfo" class="hidden p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Paciente</p>
                                    <p class="font-semibold text-gray-900" id="facturaPaciente">-</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Monto Pendiente (USD)</p>
                                    <p class="text-2xl font-bold text-blue-700" id="facturaMonto">$0.00</p>
                                    <input type="hidden" id="max_usd" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalle de Pago -->
                <div class="card p-6 shadow-sm border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-2 -mr-2 w-24 h-24 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>

                    <h3 class="text-lg font-display font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shadow-sm shadow-emerald-200">
                            <i class="bi bi-cash-stack text-sm"></i>
                        </span>
                        Información de Recaudación
                    </h3>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label font-semibold">Tasa de Cambio</label>
                                <select name="tasa_aplicada_id" id="tasa_id" class="form-select" required>
                                    @foreach($tasas as $tasa)
                                    <option value="{{ $tasa->id }}" data-valor="{{ $tasa->valor }}">
                                        {{ $tasa->nombre }} ({{ number_format($tasa->valor, 2) }} Bs.)
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label font-semibold">Monto en Bolívares (Bs.)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400">Bs.</span>
                                    <input type="number" name="monto_pagado_bs" id="monto_bs" class="input pl-12 font-bold text-lg" step="0.01" required placeholder="0.00">
                                </div>
                                <p class="text-xs text-gray-500 mt-1" id="monto_usd_calc">Equivale a: $0.00 USD</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label font-semibold">Método de Pago</label>
                                <select name="id_metodo" id="id_metodo" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($metodosPago as $metodo)
                                    <option value="{{ $metodo->id_metodo }}">{{ $metodo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label font-semibold">Referencia</label>
                                <input type="text" name="referencia" class="input" placeholder="Nro de comprobante" required>
                            </div>
                        </div>

                        <div>
                            <label class="form-label font-semibold">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" class="input" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label class="form-label font-semibold">Observaciones</label>
                            <textarea name="comentarios" rows="3" class="form-textarea" placeholder="Opcional...">{{ old('comentarios') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                <div class="card p-6">
                    <h3 class="text-lg font-display font-bold text-gray-900 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        <button type="submit" class="btn btn-success w-full">
                            <i class="bi bi-check-lg"></i>
                            Registrar Pago
                        </button>
                         <a href="{{ route('pagos.index') }}" class="btn btn-outline w-full py-3 justify-center">
                            <i class="bi bi-x-lg mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </div>

                <!-- Info -->
                <div class="card p-6 bg-emerald-50 border-emerald-200">
                    <div class="flex gap-3">
                        <i class="bi bi-info-circle text-emerald-600 text-xl"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Importante</h4>
                            <p class="text-sm text-gray-600">El pago se registrará automáticamente y se actualizará el estado de la factura.</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Details Card -->
                <div id="bank-details-card" class="card p-6 hidden bg-blue-50 border-blue-200">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <i class="bi bi-bank text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-3" id="bank-card-title">Datos Bancarios</h4>
                            
                            <!-- Transferencia -->
                            <div id="info-transf-admin" class="hidden space-y-2">
                                <div class="p-2 bg-white rounded-lg">
                                    <p class="text-xs text-blue-600 font-semibold">Banco</p>
                                    <p class="font-bold text-sm">{{ $datosBancarios['transferencia']['banco'] }}</p>
                                </div>
                                <div class="p-2 bg-white rounded-lg">
                                    <p class="text-xs text-blue-600 font-semibold">Cuenta</p>
                                    <p class="font-mono text-sm">{{ $datosBancarios['transferencia']['cuenta'] }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="p-2 bg-white rounded-lg">
                                        <p class="text-xs text-blue-600 font-semibold">Titular</p>
                                        <p class="font-bold text-xs">{{ $datosBancarios['transferencia']['titular'] }}</p>
                                    </div>
                                    <div class="p-2 bg-white rounded-lg">
                                        <p class="text-xs text-blue-600 font-semibold">RIF</p>
                                        <p class="font-bold text-xs">{{ $datosBancarios['transferencia']['rif'] }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pago Móvil -->
                            <div id="info-pagomovil-admin" class="hidden space-y-2">
                                <div class="p-2 bg-white rounded-lg">
                                    <p class="text-xs text-emerald-600 font-semibold">Banco</p>
                                    <p class="font-bold text-sm">{{ $datosBancarios['pagomovil']['banco'] }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="p-2 bg-white rounded-lg">
                                        <p class="text-xs text-emerald-600 font-semibold">Teléfono</p>
                                        <p class="font-mono text-sm">{{ $datosBancarios['pagomovil']['telefono'] }}</p>
                                    </div>
                                    <div class="p-2 bg-white rounded-lg">
                                        <p class="text-xs text-emerald-600 font-semibold">RIF</p>
                                        <p class="font-bold text-sm">{{ $datosBancarios['pagomovil']['rif'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const facturaSelect = document.getElementById('factura_id');
    const facturaInfo = document.getElementById('facturaInfo');
    const facturaPaciente = document.getElementById('facturaPaciente');
    const facturaMonto = document.getElementById('facturaMonto');
    const maxUsdInput = document.getElementById('max_usd');
    
    const tasaSelect = document.getElementById('tasa_id');
    const montoBsInput = document.getElementById('monto_bs');
    const montoUsdCalc = document.getElementById('monto_usd_calc');

    function actualizarCalculos() {
        const tasaValor = parseFloat(tasaSelect.options[tasaSelect.selectedIndex]?.getAttribute('data-valor') || 0);
        const montoBs = parseFloat(montoBsInput.value || 0);
        const maxUsd = parseFloat(maxUsdInput.value || 0);

        if (tasaValor > 0) {
            const equivalenteUsd = montoBs / tasaValor;
            montoUsdCalc.textContent = `Equivale a: $${equivalenteUsd.toFixed(2)} USD`;
            
            if (equivalenteUsd > maxUsd + 0.01 && maxUsd > 0) {
                montoUsdCalc.classList.add('text-red-600', 'font-bold');
                montoUsdCalc.textContent += ' (Excede el saldo)';
            } else {
                montoUsdCalc.classList.remove('text-red-600', 'font-bold');
            }
        }
    }

    facturaSelect?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (this.value) {
            const montoUsd = parseFloat(selected.getAttribute('data-monto-usd'));
            const paciente = selected.getAttribute('data-paciente');
            const cedula = selected.getAttribute('data-cedula');
            
            facturaPaciente.textContent = `${paciente} (${cedula})`;
            facturaMonto.textContent = `$${montoUsd.toFixed(2)}`;
            maxUsdInput.value = montoUsd;
            
            // Sugerir monto en Bs según tasa actual
            const tasaValor = parseFloat(tasaSelect.options[tasaSelect.selectedIndex]?.getAttribute('data-valor') || 0);
            montoBsInput.value = (montoUsd * tasaValor).toFixed(2);
            
            facturaInfo.classList.remove('hidden');
            actualizarCalculos();
        } else {
            facturaInfo.classList.add('hidden');
            maxUsdInput.value = 0;
        }
    });

    montoBsInput?.addEventListener('input', actualizarCalculos);
    tasaSelect?.addEventListener('change', actualizarCalculos);
    
    // Mostrar datos bancarios según método de pago seleccionado
    // Mostrar datos bancarios según método de pago seleccionado
    const metodoSelect = document.getElementById('id_metodo');
    const bankDetailsCard = document.getElementById('bank-details-card');
    const infoTransf = document.getElementById('info-transf-admin');
    const infoPagoMovil = document.getElementById('info-pagomovil-admin');
    const bankCardTitle = document.getElementById('bank-card-title');
    
    function toggleBankDetails() {
        if (!metodoSelect || !bankDetailsCard) return;

        const selectedOption = metodoSelect.options[metodoSelect.selectedIndex];
        if (!selectedOption) return;

        const metodoNombre = selectedOption.text.toLowerCase().trim();
        console.log('Método seleccionado:', metodoNombre);
        
        // Ocultar todos primero
        infoTransf?.classList.add('hidden');
        infoPagoMovil?.classList.add('hidden');
        bankDetailsCard.classList.add('hidden');
        
        // Mostrar según el método seleccionado
        if (metodoNombre.includes('transferencia')) {
            infoTransf?.classList.remove('hidden');
            if (bankCardTitle) bankCardTitle.textContent = 'Datos para Transferencia';
            bankDetailsCard.classList.remove('hidden');
        } else if (metodoNombre.includes('pago móvil') || metodoNombre.includes('pago movil') || metodoNombre.includes('pagomovil')) {
            infoPagoMovil?.classList.remove('hidden');
            if (bankCardTitle) bankCardTitle.textContent = 'Datos Pago Móvil';
            bankDetailsCard.classList.remove('hidden');
        }
    }

    if (metodoSelect) {
        metodoSelect.addEventListener('change', toggleBankDetails);
        // Ejecutar al cargar por si hay un valor seleccionado
        toggleBankDetails();
    }
});
</script>
@endsection
