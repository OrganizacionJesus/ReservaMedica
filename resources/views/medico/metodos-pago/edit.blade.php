@extends('layouts.medico')

@section('title', $datosPago ? 'Editar Métodos de Pago' : 'Registrar Métodos de Pago')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900">
                {{ $datosPago ? 'Editar' : 'Registrar' }} Métodos de Pago
            </h1>
            <p class="text-gray-600 mt-1">Configura tus datos bancarios para recibir liquidaciones</p>
        </div>
        <a href="{{ route('medico.metodos-pago.index') }}" class="btn btn-outline">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- Form --}}
    <form id="paymentForm" method="POST" action="{{ route('medico.metodos-pago.store') }}" class="space-y-6">
        @csrf
        
        {{-- Datos Bancarios --}}
        <div class="card p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="bi bi-bank text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Datos Bancarios</h3>
                    <p class="text-sm text-gray-600">Información de tu cuenta bancaria</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Banco --}}
                <div class="md:col-span-2">
                    <label for="banco" class="block text-sm font-semibold text-gray-700 mb-2">
                        Banco <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="banco" 
                        id="banco"
                        value="{{ old('banco', $datosPago->banco ?? '') }}"
                        class="form-input w-full"
                        placeholder="Ej: Banco Provincial"
                        required
                    >
                    <p class="mt-1 text-xs text-rose-600 hidden" id="error_banco"></p>
                    @error('banco')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo de Cuenta --}}
                <div>
                    <label for="tipo_cuenta" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipo de Cuenta <span class="text-rose-500">*</span>
                    </label>
                    <select name="tipo_cuenta" id="tipo_cuenta" class="form-select w-full" required>
                        <option value="">Seleccione...</option>
                        <option value="Ahorro" {{ old('tipo_cuenta', $datosPago->tipo_cuenta ?? '') == 'Ahorro' ? 'selected' : '' }}>
                            Ahorro
                        </option>
                        <option value="Corriente" {{ old('tipo_cuenta', $datosPago->tipo_cuenta ?? '') == 'Corriente' ? 'selected' : '' }}>
                            Corriente
                        </option>
                    </select>
                    <p class="mt-1 text-xs text-rose-600 hidden" id="error_tipo_cuenta"></p>
                    @error('tipo_cuenta')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Número de Cuenta --}}
                <div>
                    <label for="numero_cuenta" class="block text-sm font-semibold text-gray-700 mb-2">
                        Número de Cuenta <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="numero_cuenta" 
                        id="numero_cuenta"
                        value="{{ old('numero_cuenta', $datosPago->numero_cuenta ?? '') }}"
                        class="form-input w-full font-mono tracking-wider"
                        placeholder="0108-1234-56-7890123456"
                        maxlength="23"
                        required
                    >
                    <p class="mt-1 text-xs text-rose-600 hidden" id="error_numero_cuenta"></p>
                    @error('numero_cuenta')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Titular --}}
                <div>
                    <label for="titular" class="block text-sm font-semibold text-gray-700 mb-2">
                        Titular de la Cuenta <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titular" 
                        id="titular"
                        value="{{ old('titular', $datosPago->titular ?? '') }}"
                        class="form-input w-full"
                        placeholder="Nombre completo del titular"
                        maxlength="200"
                        required
                    >
                    <p class="mt-1 text-xs text-rose-600 hidden" id="error_titular"></p>
                    @error('titular')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cédula (Dividida) --}}
                <div>
                    <label for="cedula_numero" class="block text-sm font-semibold text-gray-700 mb-2">
                        Cédula del Titular <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <select id="tipo_documento" class="form-select w-24 flex-shrink-0">
                            @php
                                $cedulaFull = old('cedula', $datosPago->cedula ?? '');
                                $tipoDoc = '';
                                $numDoc = '';
                                if(strpos($cedulaFull, '-') !== false) {
                                    list($tipoDoc, $numDoc) = explode('-', $cedulaFull, 2);
                                } else {
                                    $numDoc = $cedulaFull;
                                }
                            @endphp
                            <option value="V" {{ $tipoDoc == 'V' ? 'selected' : '' }}>V-</option>
                            <option value="E" {{ $tipoDoc == 'E' ? 'selected' : '' }}>E-</option>
                            <option value="J" {{ $tipoDoc == 'J' ? 'selected' : '' }}>J-</option>
                            <option value="G" {{ $tipoDoc == 'G' ? 'selected' : '' }}>G-</option>
                            <option value="P" {{ $tipoDoc == 'P' ? 'selected' : '' }}>P-</option>
                        </select>
                        <input 
                            type="text" 
                            id="numero_documento"
                            value="{{ $numDoc }}"
                            class="form-input w-full"
                            placeholder="12345678"
                            maxlength="15"
                            required
                        >
                    </div>
                    {{-- Campo oculto que se envía al backend --}}
                    <input type="hidden" name="cedula" id="cedula" value="{{ old('cedula', $datosPago->cedula ?? '') }}">
                    
                    <p class="mt-1 text-xs text-rose-600 hidden" id="error_cedula"></p>
                    @error('cedula')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Método de Pago Preferido --}}
        <div class="card p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="bi bi-star-fill text-amber-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Método Preferido</h3>
                    <p class="text-sm text-gray-600">Selecciona cómo prefieres recibir tus liquidaciones</p>
                </div>
            </div>

            <div>
                <label for="metodo_pago_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Método de Pago <span class="text-rose-500">*</span>
                </label>
                <select name="metodo_pago_id" id="metodo_pago_id" class="form-select w-full" required>
                    <option value="">Seleccione un método...</option>
                    @foreach($metodosPago as $metodo)
                        @php
                            $nombreNormalizado = strtolower($metodo->nombre);
                            // Filtro estricto: Solo Pago Móvil, Transferencia, Efectivo
                            $permitido = str_contains($nombreNormalizado, 'movil') || 
                                       str_contains($nombreNormalizado, 'móvil') || 
                                       str_contains($nombreNormalizado, 'transferencia') || 
                                       str_contains($nombreNormalizado, 'efectivo');
                        @endphp
                        
                        @if($permitido)
                            <option value="{{ $metodo->id_metodo }}" 
                                {{ old('metodo_pago_id', $datosPago->metodo_pago_id ?? '') == $metodo->id_metodo ? 'selected' : '' }}>
                                {{ $metodo->nombre }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-rose-600 hidden" id="error_metodo_pago"></p>
                @error('metodo_pago_id')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Información de Contacto --}}
        <div class="card p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="bi bi-telephone-fill text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Información de Contacto</h3>
                    <p class="text-sm text-gray-600">Opcional: Número de contacto para confirmaciones</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Prefijo --}}
                <div>
                    <label for="prefijo_tlf" class="block text-sm font-semibold text-gray-700 mb-2">
                        Prefijo
                    </label>
                    <select name="prefijo_tlf" id="prefijo_tlf" class="form-select w-full">
                        <option value="">--</option>
                        <option value="0412" {{ old('prefijo_tlf', $datosPago->prefijo_tlf ?? '') == '0412' ? 'selected' : '' }}>0412</option>
                        <option value="0414" {{ old('prefijo_tlf', $datosPago->prefijo_tlf ?? '') == '0414' ? 'selected' : '' }}>0414</option>
                        <option value="0424" {{ old('prefijo_tlf', $datosPago->prefijo_tlf ?? '') == '0424' ? 'selected' : '' }}>0424</option>
                        <option value="0416" {{ old('prefijo_tlf', $datosPago->prefijo_tlf ?? '') == '0416' ? 'selected' : '' }}>0416</option>
                        <option value="0426" {{ old('prefijo_tlf', $datosPago->prefijo_tlf ?? '') == '0426' ? 'selected' : '' }}>0426</option>
                        <option value="0212" {{ old('prefijo_tlf', $datosPago->prefijo_tlf ?? '') == '0212' ? 'selected' : '' }}>0212</option>
                    </select>
                </div>

                {{-- Número --}}
                <div class="md:col-span-2">
                    <label for="numero_tlf" class="block text-sm font-semibold text-gray-700 mb-2">
                        Número de Teléfono
                    </label>
                    <input 
                        type="text" 
                        name="numero_tlf" 
                        id="numero_tlf"
                        value="{{ old('numero_tlf', $datosPago->numero_tlf ?? '') }}"
                        class="form-input w-full"
                        placeholder="1234567"
                        maxlength="7"
                    >
                    <p class="mt-1 text-xs text-rose-600 hidden" id="error_numero_tlf"></p>
                    @error('numero_tlf')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Estado --}}
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Estado del Método de Pago</h3>
                    <p class="text-sm text-gray-600">Si está inactivo, no podrás recibir liquidaciones</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="status" 
                        value="1" 
                        class="sr-only peer"
                        {{ old('status', $datosPago->status ?? true) ? 'checked' : '' }}
                    >
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900">Activo</span>
                </label>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('medico.metodos-pago.index') }}" class="btn btn-outline">
                Cancelar
            </a>
            <button type="submit" class="btn btn-success" id="submitBtn">
                <i class="bi bi-check-circle"></i> Guardar Métodos de Pago
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const cuentaInput = document.getElementById('numero_cuenta');
    const docNumInput = document.getElementById('numero_documento');
    const tipoDocSelect = document.getElementById('tipo_documento');
    const cedulaHidden = document.getElementById('cedula');
    const tlfInput = document.getElementById('numero_tlf');
    const titularInput = document.getElementById('titular');
    const bancoInput = document.getElementById('banco');

    // --- Funciones de Validación y Formato ---

    // Formatear cuenta bancaria 0108-1234-56-7890123456
    cuentaInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Solo números
        let formatted = '';

        if (value.length > 0) formatted += value.substring(0, 4);
        if (value.length > 4) formatted += '-' + value.substring(4, 8);
        if (value.length > 8) formatted += '-' + value.substring(8, 10);
        if (value.length > 10) formatted += '-' + value.substring(10, 20);

        e.target.value = formatted;
        
        if (value.length >= 20) {
            clearError(e.target);
        }
    });

    cuentaInput.addEventListener('blur', function() {
        let value = this.value.replace(/\D/g, '');
        validateField(this, value.length >= 20, "El número de cuenta debe tener 20 dígitos.");
    });

    // Validar solo números en documento
    docNumInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
        updateHiddenCedula();
        if (value.length >= 6) clearError(e.target);
    });
    
    docNumInput.addEventListener('blur', function() {
        validateField(this, this.value.length >= 6, "El documento debe tener al menos 6 dígitos.");
    });

    tipoDocSelect.addEventListener('change', updateHiddenCedula);

    function updateHiddenCedula() {
        cedulaHidden.value = `${tipoDocSelect.value}-${docNumInput.value}`;
    }

    // Validar solo números en teléfono
    tlfInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
        if(value.length > 0) {
            if(value.length === 7) clearError(e.target);
        } else {
            clearError(e.target);
        }
    });

    // Validaciones al salir del campo (blur)
    bancoInput.addEventListener('blur', function() {
        validateField(this, this.value.trim().length > 3, "Ingrese un nombre de banco válido.");
    });
    
    titularInput.addEventListener('blur', function() {
        validateField(this, this.value.trim().length > 5, "Ingrese el nombre completo del titular.");
    });

    // --- Helpers de Validación Visual ---

    function validateField(input, condition, message) {
        let errorSpan = document.getElementById('error_' + input.id) || 
                          document.getElementById('error_' + input.getAttribute('name')) ||
                          input.parentElement.querySelector('.text-rose-600');
        
        // Si es el campo oculto de cedula, el span está cerca del select/input grupo
        if(input.id === 'numero_documento') errorSpan = document.getElementById('error_cedula');

        if (!condition) {
            input.classList.add('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500');
            input.classList.remove('border-gray-300', 'focus:border-emerald-500', 'focus:ring-emerald-500');
            if (errorSpan) {
                errorSpan.textContent = message;
                errorSpan.classList.remove('hidden');
            }
        } else {
            clearError(input, errorSpan);
        }
    }

    function clearError(input, errorSpan = null) {
        input.classList.remove('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500');
        input.classList.add('border-gray-300', 'focus:border-emerald-500', 'focus:ring-emerald-500');
        
        if (!errorSpan) {
            errorSpan = document.getElementById('error_' + input.id) || 
                        document.getElementById('error_' + input.getAttribute('name'));
            if(input.id === 'numero_documento') errorSpan = document.getElementById('error_cedula');
        }
        
        if (errorSpan) {
            errorSpan.classList.add('hidden');
            errorSpan.textContent = '';
        }
    }

    // Validación Final al Enviar
    form.addEventListener('submit', function(e) {
        updateHiddenCedula();
        let isValid = true;

        // Validar campos obligatorios
        if (!bancoInput.value.trim()) { validateField(bancoInput, false, "Campo requerido"); isValid = false; }
        if (!titularInput.value.trim()) { validateField(titularInput, false, "Campo requerido"); isValid = false; }
        if (cuentaInput.value.replace(/\D/g, '').length !== 20) { validateField(cuentaInput, false, "Debe tener 20 dígitos"); isValid = false; }
        if (!docNumInput.value.trim()) { validateField(docNumInput, false, "Campo requerido"); isValid = false; }

        if (!isValid) {
            e.preventDefault();
            // Scroll al primer error
            const firstError = document.querySelector('.border-rose-500');
            if(firstError) firstError.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    });
});
</script>
@endsection
