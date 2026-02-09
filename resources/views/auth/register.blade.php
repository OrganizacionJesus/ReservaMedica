@extends('layouts.auth')

@section('title', 'Crear Cuenta')
@section('box-width', 'max-w-[1400px]')
@section('form-width', 'max-w-2xl')

@section('auth-content')
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <span
                class="px-3 py-1 bg-medical-100 text-medical-600 text-xs font-bold rounded-full uppercase tracking-wider">Registro
                de Paciente</span>
        </div>
        <h2 class="text-3xl font-display font-bold text-slate-900 tracking-tight">
            Bienvenido a MediReserva
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Completa tu registro en 3 sencillos pasos para empezar a gestionar tus citas.
        </p>
    </div>

    <!-- Steps Progress Bar -->
    <div class="mb-10 relative">
        <div class="flex justify-between items-center w-full relative z-10">
            <!-- Step 1 -->
            <div class="flex flex-col items-center">
                <div id="ind-1"
                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-medical-600 text-white font-bold shadow-lg shadow-medical-200 transition-all duration-300">
                    1
                </div>
                <span id="text-1" class="text-[10px] sm:text-xs font-bold mt-2 text-medical-600">Personal</span>
            </div>

            <!-- Connector 1-2 -->
            <div class="flex-1 h-1 mx-2 rounded-full bg-slate-100 overflow-hidden">
                <div id="prog-1" class="h-full bg-medical-600 transition-all duration-500" style="width: 0%"></div>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col items-center">
                <div id="ind-2"
                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 text-slate-400 font-bold transition-all duration-300">
                    2
                </div>
                <span id="text-2" class="text-[10px] sm:text-xs font-bold mt-2 text-slate-400">Ubicación</span>
            </div>

            <!-- Connector 2-3 -->
            <div class="flex-1 h-1 mx-2 rounded-full bg-slate-100 overflow-hidden">
                <div id="prog-2" class="h-full bg-medical-600 transition-all duration-500" style="width: 0%"></div>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col items-center">
                <div id="ind-3"
                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 text-slate-400 font-bold transition-all duration-300">
                    3
                </div>
                <span id="text-3" class="text-[10px] sm:text-xs font-bold mt-2 text-slate-400">Seguridad</span>
<div class="mb-6 text-center">
    <h2 class="text-2xl font-display font-bold text-slate-900 tracking-tight">
        Crear Cuenta Nueva
    </h2>
    <p class="mt-2 text-sm text-slate-500">
        Regístrate como paciente en 3 sencillos pasos
    </p>
</div>

<!-- Steps Indicators -->
<div class="mb-8 relative">
    <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -z-10 -translate-y-1/2 rounded"></div>
    <div class="flex justify-between w-full max-w-xs mx-auto">
        <div class="step-indicator group" data-step="1">
            <div id="ind-1" class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-600 text-white font-bold ring-4 ring-white transition-all duration-300 shadow-md">1</div>
        </div>
        <div class="step-indicator group relative" data-step="2">
            <div id="ind-2" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold ring-4 ring-white transition-all duration-300 border-2 border-transparent">2</div>
            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 w-max"><span id="text-2" class="text-xs font-semibold text-gray-400">Ubicación</span></div>
        </div>
        <div class="step-indicator group relative" data-step="3">
            <div id="ind-3" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold ring-4 ring-white transition-all duration-300 border-2 border-transparent">3</div>
            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 w-max"><span id="text-3" class="text-xs font-semibold text-gray-400">Cuenta</span></div>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
    <p class="text-sm font-semibold text-red-700 mb-2">Por favor corrige los siguientes errores:</p>
    <ul class="list-disc list-inside text-sm text-red-600">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-6">
    @csrf
    
    <!-- Paso 1: Información Personal -->
    <div id="step-1" class="form-step animate-fade-in">
        <input type="hidden" name="rol_id" value="3">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
            <!-- Primer Nombre -->
            <div>
                <label for="primer_nombre" class="block text-sm font-medium text-slate-700">Primer Nombre *</label>
                <input type="text" name="primer_nombre" id="primer_nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('primer_nombre') border-red-500 @enderror" required value="{{ old('primer_nombre') }}">
                <span id="error-primer_nombre" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('primer_nombre')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Segundo Nombre -->
            <div>
                <label for="segundo_nombre" class="block text-sm font-medium text-slate-700">Segundo Nombre (Opcional)</label>
                <input type="text" name="segundo_nombre" id="segundo_nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('segundo_nombre') border-red-500 @enderror" value="{{ old('segundo_nombre') }}">
                <span id="error-segundo_nombre" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('segundo_nombre')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Primer Apellido -->
            <div>
                <label for="primer_apellido" class="block text-sm font-medium text-slate-700">Primer Apellido *</label>
                <input type="text" name="primer_apellido" id="primer_apellido" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('primer_apellido') border-red-500 @enderror" required value="{{ old('primer_apellido') }}">
                <span id="error-primer_apellido" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('primer_apellido')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Segundo Apellido -->
            <div>
                <label for="segundo_apellido" class="block text-sm font-medium text-slate-700">Segundo Apellido (Opcional)</label>
                <input type="text" name="segundo_apellido" id="segundo_apellido" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('segundo_apellido') border-red-500 @enderror" value="{{ old('segundo_apellido') }}">
                <span id="error-segundo_apellido" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('segundo_apellido')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-6">
        @csrf
        <input type="hidden" name="rol_id" value="3">

        <!-- Paso 1: Información Personal -->
        <div id="step-1" class="form-step animate-fade-in space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Nombres -->
                <div class="group">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Primer Nombre *</label>
                    <div class="relative">
                        <input type="text" name="primer_nombre" id="primer_nombre"
                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 focus:ring-4 focus:ring-medical-500/10 transition-all outline-none text-sm"
                            placeholder="Ej. Juan" required value="{{ old('primer_nombre') }}">
                        <span id="error-primer_nombre" class="text-[10px] text-red-500 font-bold mt-1 hidden block"></span>
                    </div>
                </div>
                <div class="group">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Segundo Nombre</label>
                    <div class="relative">
                        <input type="text" name="segundo_nombre" id="segundo_nombre"
                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 focus:ring-4 focus:ring-medical-500/10 transition-all outline-none text-sm"
                            placeholder="Ej. Antonio" value="{{ old('segundo_nombre') }}">
                    </div>
                </div>

                <!-- Apellidos -->
                <div class="group">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Primer Apellido *</label>
                    <div class="relative">
                        <input type="text" name="primer_apellido" id="primer_apellido"
                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 focus:ring-4 focus:ring-medical-500/10 transition-all outline-none text-sm"
                            placeholder="Ej. Pérez" required value="{{ old('primer_apellido') }}">
                    </div>
                </div>
                <div class="group">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Segundo Apellido</label>
                    <div class="relative">
                        <input type="text" name="segundo_apellido" id="segundo_apellido"
                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 focus:ring-4 focus:ring-medical-500/10 transition-all outline-none text-sm"
                            placeholder="Ej. Rodríguez" value="{{ old('segundo_apellido') }}">
                    </div>
                </div>

                <!-- Identificación -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Documento de Identidad *</label>
                    <div class="flex gap-2">
                        <select name="tipo_documento" id="tipo_documento"
                            class="w-20 px-3 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm">
                            <option value="V" {{ old('tipo_documento') == 'V' ? 'selected' : '' }}>V</option>
                            <option value="E" {{ old('tipo_documento') == 'E' ? 'selected' : '' }}>E</option>
                            <option value="P" {{ old('tipo_documento') == 'P' ? 'selected' : '' }}>P</option>
                        </select>
                        <input type="text" name="numero_documento" id="numero_documento"
                            class="flex-1 px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 focus:ring-4 focus:ring-medical-500/10 transition-all outline-none text-sm"
                            placeholder="12345678" required value="{{ old('numero_documento') }}">
                    </div>
                    <span id="error-numero_documento" class="text-[10px] text-red-500 font-bold mt-1 hidden block"></span>
                </div>

                <!-- Sexo -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Género *</label>
                    <select name="genero" id="genero"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                        required>
                        <option value="">Seleccionar...</option>
                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    </select>
                </div>

                <!-- Fecha Nacimiento -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Fecha de Nacimiento *</label>
                    <input type="date" name="fecha_nac" id="fecha_nac"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                        required value="{{ old('fecha_nac') }}">
                    <span id="label-edad" class="text-[10px] text-slate-500 font-bold mt-1 block tracking-tight">Debes ser
                        mayor de 18 años</span>
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Teléfono Móvil *</label>
                    <div class="flex gap-2">
                        <select name="prefijo_tlf"
                            class="w-24 px-2 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm">
                            <option value="+58" selected>+58 (VE)</option>
                            <option value="+57">+57 (CO)</option>
                            <option value="+1">+1 (US)</option>
                        </select>
                        <input type="tel" name="numero_tlf" id="numero_tlf"
                            class="flex-1 px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                            placeholder="4121234567" required value="{{ old('numero_tlf') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 2: Ubicación -->
        <div id="step-2" class="form-step hidden animate-fade-in space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Estado de Residencia *</label>
                <select name="estado_id" id="estado_id"
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                    required>
                    <option value="">Seleccionar Estado...</option>
                    @foreach($estados ?? [] as $estado)
                        <option value="{{ $estado->id_estado }}" {{ old('estado_id') == $estado->id_estado ? 'selected' : '' }}>
                            {{ $estado->estado }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Ciudad</label>
                    <select name="ciudad_id" id="ciudad_id"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm">
                        <option value="">Selecciona un estado...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Municipio</label>
                    <select name="municipio_id" id="municipio_id"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm">
                        <option value="">Selecciona un estado...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Parroquia</label>
                    <select name="parroquia_id" id="parroquia_id"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm">
                        <option value="">Selecciona un municipio...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Ocupación / Profesión</label>
                    <input type="text" name="ocupacion"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                        placeholder="Ej. Ingeniero" value="{{ old('ocupacion') }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Dirección Detallada</label>
                <textarea name="direccion" id="direccion" rows="2"
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm resize-none"
                    placeholder="Calle, edificio, urbanización...">{{ old('direccion') }}</textarea>
            <!-- Cédula -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Cédula *</label>
                <div class="flex gap-2 mt-1">
                    <select name="tipo_documento" id="tipo_documento" class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        <option value="V" {{ old('tipo_documento') == 'V' ? 'selected' : '' }}>V</option>
                        <option value="E" {{ old('tipo_documento') == 'E' ? 'selected' : '' }}>E</option>
                        <option value="P" {{ old('tipo_documento') == 'P' ? 'selected' : '' }}>P</option>
                        <option value="J" {{ old('tipo_documento') == 'J' ? 'selected' : '' }}>J</option>
                    </select>
                    <input type="text" name="numero_documento" id="numero_documento" placeholder="12345678901" class="block flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('numero_documento') border-red-500 @enderror" required maxlength="12" value="{{ old('numero_documento') }}">
                </div>
                <span id="error-numero_documento" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('numero_documento')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Fecha Nacimiento -->
            <div>
                <label for="fecha_nac" class="block text-sm font-medium text-slate-700">Fecha Nacimiento *</label>
                <input type="date" name="fecha_nac" id="fecha_nac" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('fecha_nac') border-red-500 @enderror" required value="{{ old('fecha_nac') }}">
                <span id="label-edad" class="text-xs text-slate-500 font-medium mt-1 block">Para Crear una Cuenta Debe ser Mayor de Edad</span>
                <span id="error-fecha_nac" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('fecha_nac')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Sexo -->
            <div>
                <label for="genero" class="block text-sm font-medium text-slate-700">Sexo *</label>
                <select name="genero" id="genero" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('genero') border-red-500 @enderror" required>
                    <option value="">Seleccionar...</option>
                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                <span id="error-genero" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('genero')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Teléfono *</label>
                <div class="flex gap-2 mt-1">
                    <select name="prefijo_tlf" id="prefijo_tlf" class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        <option value="+58" {{ old('prefijo_tlf') == '+58' ? 'selected' : '' }}>+58</option>
                        <option value="+57" {{ old('prefijo_tlf') == '+57' ? 'selected' : '' }}>+57</option>
                        <option value="+1" {{ old('prefijo_tlf') == '+1' ? 'selected' : '' }}>+1</option>
                        <option value="+34" {{ old('prefijo_tlf') == '+34' ? 'selected' : '' }}>+34</option>
                    </select>
                    <input type="tel" name="numero_tlf" id="numero_tlf" placeholder="4121234567" class="block flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('numero_tlf') border-red-500 @enderror" required maxlength="15" value="{{ old('numero_tlf') }}">
                </div>
                <span id="error-numero_tlf" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('numero_tlf')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <!-- Paso 2: Ubicación -->
    <div id="step-2" class="form-step hidden animate-fade-in">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="estado_id" class="block text-sm font-medium text-slate-700">Estado *</label>
                <select name="estado_id" id="estado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    <option value="">Seleccionar estado...</option>
                     @foreach($estados ?? [] as $estado)
                        <option value="{{ $estado->id_estado }}" {{ old('estado_id') == $estado->id_estado ? 'selected' : '' }}>{{ $estado->estado }}</option>
                    @endforeach
                </select>
                <span id="error-estado_id" class="text-xs text-red-600 mt-1 hidden"></span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                     <label for="ciudad_id" class="block text-sm font-medium text-slate-700">Ciudad</label>
                     <select name="ciudad_id" id="ciudad_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                         <option value="">Primero selecciona estado...</option>
                     </select>
                </div>
                 <div>
                     <label for="municipio_id" class="block text-sm font-medium text-slate-700">Municipio</label>
                     <select name="municipio_id" id="municipio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                         <option value="">Primero selecciona estado...</option>
                     </select>
                </div>
            </div>

        <!-- Paso 3: Seguridad -->
        <div id="step-3" class="form-step hidden animate-fade-in space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Correo Electrónico *</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-envelope text-slate-400"></i>
                    </div>
                    <input type="email" name="correo" id="correo"
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                        placeholder="tu@email.com" required value="{{ old('correo') }}">
                </div>
                <span id="error-correo" class="text-[10px] text-red-500 font-bold mt-1 hidden block"></span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contraseña *</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                        placeholder="••••••••" required>

                    <div class="mt-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest">Requisitos de
                            Seguridad</p>
                        <ul class="space-y-1.5">
                            <li id="req-length" class="text-xs text-slate-500 flex items-center gap-2"><i
                                    class="bi bi-circle"></i> 8+ caracteres</li>
                            <li id="req-upper" class="text-xs text-slate-500 flex items-center gap-2"><i
                                    class="bi bi-circle"></i> Una mayúscula</li>
                            <li id="req-number" class="text-xs text-slate-500 flex items-center gap-2"><i
                                    class="bi bi-circle"></i> Un número</li>
                            <li id="req-symbol" class="text-xs text-slate-500 flex items-center gap-2"><i
                                    class="bi bi-circle"></i> Un símbolo</li>
                        </ul>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Confirmar Contraseña *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-medical-500 outline-none text-sm"
                        placeholder="••••••••" required>
                </div>
            </div>

            <!-- Security Questions Modernized -->
            <div class="bg-blue-50/50 p-5 rounded-2xl border-2 border-blue-100/50">
                <h4 class="text-sm font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <i class="bi bi-shield-lock-fill"></i>
                    Preguntas de Seguridad
                </h4>
                <div class="space-y-4">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="space-y-2">
                            <select name="pregunta_seguridad_{{ $i }}" id="pregunta_seguridad_{{ $i }}"
                                class="w-full px-3 py-2.5 bg-white border-2 border-blue-100 rounded-xl text-xs focus:border-blue-400 outline-none transition-all"
                                required>
                                <option value="">Seleccionar Pregunta {{ $i }}...</option>
                                @foreach($preguntas ?? [] as $pregunta)
                                    <option value="{{ $pregunta->id }}" {{ old("pregunta_seguridad_$i") == $pregunta->id ? 'selected' : '' }}>{{ $pregunta->pregunta }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="respuesta_seguridad_{{ $i }}"
                                class="w-full px-3 py-2.5 bg-white border-2 border-blue-100 rounded-xl text-xs focus:border-blue-400 outline-none transition-all"
                                placeholder="Tu respuesta secreta" required value="{{ old("respuesta_seguridad_$i") }}">
                        </div>
                    @endfor
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer p-2 rounded-xl hover:bg-slate-50 transition-colors">
                <input type="checkbox" name="terminos" required
                    class="w-5 h-5 text-medical-600 bg-slate-100 border-slate-300 rounded focus:ring-medical-500">
                <span class="text-xs text-slate-600">Acepto los <a href="#"
                        class="text-medical-600 font-bold hover:underline">Términos y Condiciones</a> del servicio.</span>
            </label>
        </div>

        <!-- Navigation Buttons Modernized -->
        <div class="flex items-center justify-between pt-8 mt-4 border-t border-slate-100">
            <a href="{{ route('login') }}"
                class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                Iniciar Sesión
            </a>

            <div class="flex gap-3">
                <button type="button" id="prevBtn"
                    class="hidden px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm"
                    onclick="window.changeStep(-1)">
                    Anterior
                </button>

                <button type="button" id="nextBtn"
                    class="px-8 py-3 bg-medical-600 text-white font-bold rounded-xl shadow-lg shadow-medical-200 hover:bg-medical-700 hover:-translate-y-0.5 active:translate-y-0 transition-all text-sm flex items-center gap-2"
                    onclick="window.changeStep(1)">
                    Siguiente
                    <i class="bi bi-arrow-right"></i>
                </button>

                <button type="submit" id="submitBtn"
                    class="hidden px-8 py-3 bg-gradient-to-r from-medical-600 to-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:opacity-90 hover:-translate-y-0.5 active:translate-y-0 transition-all text-sm flex items-center gap-2">
                    Crear Mi Cuenta
                    <i class="bi bi-check2-circle"></i>
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
        <script type="module">
            import { showToast, shakeElement, toggleSubmitButton } from '{{ asset("js/alerts.js") }}';

            window.currentStep = 1;
            window.totalSteps = 3;

            // --- Step Functionality ---
            window.changeStep = async function (dir) {
                if (dir === 1) {
                    const stepValid = await window.validateStep(window.currentStep);
                    if (!stepValid) return;
                }

                const nextStep = window.currentStep + dir;
                if (nextStep >= 1 && nextStep <= window.totalSteps) {
                    window.showStep(nextStep);
                }
            }

            window.showStep = function (step) {
                document.querySelectorAll('.form-step').forEach(el => el.classList.add('hidden'));
                document.getElementById('step-' + step).classList.remove('hidden');

                // Update buttons
                document.getElementById('prevBtn').classList.toggle('hidden', step === 1);
                document.getElementById('nextBtn').classList.toggle('hidden', step === window.totalSteps);
                document.getElementById('submitBtn').classList.toggle('hidden', step !== window.totalSteps);

                // Update progress bar
                updateProgressBar(step);
                window.currentStep = step;

                // Scroll to top of form smoothly
                document.querySelector('form').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            function updateProgressBar(step) {
                for (let i = 1; i <= 3; i++) {
                    const ind = document.getElementById('ind-' + i);
                    const txt = document.getElementById('text-' + i);
                    const prog = document.getElementById('prog-' + (i - 1));

                    if (i < step) {
                        // Completed
                        ind.className = "w-10 h-10 rounded-xl flex items-center justify-center bg-green-500 text-white font-bold shadow-lg shadow-green-100 transition-all duration-300";
                        ind.innerHTML = '<i class="bi bi-check-lg"></i>';
                        txt.className = "text-[10px] sm:text-xs font-bold mt-2 text-green-600";
                        if (prog) prog.style.width = '100%';
                    } else if (i === step) {
                        // Current
                        ind.className = "w-10 h-10 rounded-xl flex items-center justify-center bg-medical-600 text-white font-bold shadow-lg shadow-medical-200 transition-all duration-300 transform scale-110";
                        ind.innerHTML = i;
                        txt.className = "text-[10px] sm:text-xs font-bold mt-2 text-medical-600";
                        if (prog) prog.style.width = '50%';
                    } else {
                        // Pending
                        ind.className = "w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 text-slate-400 font-bold transition-all duration-300";
                        ind.innerHTML = i;
                        txt.className = "text-[10px] sm:text-xs font-bold mt-2 text-slate-400";
                        if (prog) prog.style.width = '0%';
                    }
                }
            }

            // --- Validation Logic ---
            window.validateStep = async function (step) {
                let isValid = true;
                const form = document.getElementById('registerForm');

                if (step === 1) {
                    const fields = ['primer_nombre', 'primer_apellido', 'numero_documento', 'fecha_nac', 'genero', 'numero_tlf'];
                    fields.forEach(f => {
                        const input = document.getElementById(f);
                        if (!input.value.trim()) {
                            isValid = false;
                            shakeElement(input);
                            input.classList.add('border-red-300');
                        } else {
                            input.classList.remove('border-red-300');
                        }
                    });

                    // Age check
                    const dob = new Date(document.getElementById('fecha_nac').value);
                    const age = new Date().getFullYear() - dob.getFullYear();
                    if (age < 18) {
                        isValid = false;
                        showToast('error', 'Debes ser mayor de 18 años para registrarte.');
                        shakeElement(document.getElementById('fecha_nac'));
                    }

                    // AJAX Document Check
                    if (isValid) {
                        const res = await checkDocumentAvailability();
                        if (!res) isValid = false;
                    }
                }

                if (step === 2) {
                    const estado = document.getElementById('estado_id');
                    if (!estado.value) {
                        isValid = false;
                        shakeElement(estado);
                    }
                }

                if (step === 3) {
                    const correo = document.getElementById('correo');
                    const pass = document.getElementById('password');
                    const confirm = document.getElementById('password_confirmation');

                    if (!correo.value || !pass.value || !confirm.value) {
                        isValid = false;
                        if (!correo.value) shakeElement(correo);
                        if (!pass.value) shakeElement(pass);
                    }

                    if (pass.value !== confirm.value) {
                        isValid = false;
                        showToast('error', 'Las contraseñas no coinciden.');
                        shakeElement(confirm);
                    }

                    // AJAX Email Check
                    if (isValid) {
                        const res = await checkEmailAvailability();
                        if (!res) isValid = false;
                    }
                }

                return isValid;
            }

            async function checkDocumentAvailability() {
                const input = document.getElementById('numero_documento');
                const tipo = document.getElementById('tipo_documento').value;
                const num = input.value;

                try {
                    const response = await fetch("{{ route('recovery.get-questions') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ identifier: num })
                    });
                    const data = await response.json();
                    if (data.success) { // If it's found, it means it already exists
                        showToast('error', 'Este número de documento ya está registrado.');
                        shakeElement(input);
                        input.classList.add('border-red-300');
                        return false;
                    }
                    return true;
                } catch (e) { return true; }
            }

            async function checkEmailAvailability() {
                const input = document.getElementById('correo');
                const email = input.value;

                try {
                    const response = await fetch("{{ route('validate.email') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ correo: email })
                    });
                    const data = await response.json();
                    if (data.existe) {
                        showToast('error', 'Este correo electrónico ya está registrado.');
                        shakeElement(input);
                        input.classList.add('border-red-300');
                        return false;
                    }
                    return true;
                } catch (e) { return true; }
            }

            // Password strength feedback
            document.getElementById('password').addEventListener('input', function () {
                const val = this.value;
                const reqs = {
                    length: val.length >= 8,
                    upper: /[A-Z]/.test(val),
                    number: /[0-9]/.test(val),
                    symbol: /[@$!%*#?&.]/.test(val)
                };

                Object.keys(reqs).forEach(key => {
                    const el = document.getElementById('req-' + key);
                    if (reqs[key]) {
                        el.className = "text-xs text-green-600 font-bold flex items-center gap-2";
                        el.querySelector('i').className = "bi bi-check-circle-fill";
                    } else {
                        el.className = "text-xs text-slate-500 flex items-center gap-2";
                        el.querySelector('i').className = "bi bi-circle";
                    }
                });
            });

            // Final submit
            document.getElementById('registerForm').addEventListener('submit', function (e) {
                toggleSubmitButton(document.getElementById('submitBtn'), true, 'Procesando...');
            });

            // Dynamic location loading (replicated from shared/usuarios/create.blade.php)
            document.getElementById('estado_id').addEventListener('change', function () {
                const estadoId = this.value;
                const ciudadSelect = document.getElementById('ciudad_id');
                const municipioSelect = document.getElementById('municipio_id');
                const parroquiaSelect = document.getElementById('parroquia_id');

                ciudadSelect.innerHTML = '<option value="">Cargando...</option>';
                municipioSelect.innerHTML = '<option value="">Selecciona un estado...</option>';
                parroquiaSelect.innerHTML = '<option value="">Selecciona un municipio...</option>';

                if (estadoId) {
                    fetch(`{{ url('ubicacion/get-ciudades') }}/${estadoId}`)
                        .then(r => r.json())
                        .then(d => {
                            ciudadSelect.innerHTML = '<option value="">Seleccionar Ciudad...</option>';
                            d.forEach(i => ciudadSelect.innerHTML += `<option value="${i.id_ciudad}">${i.ciudad}</option>`);
                        })
                        .catch(e => console.error('Error loading ciudades:', e));

                    fetch(`{{ url('ubicacion/get-municipios') }}/${estadoId}`)
                        .then(r => r.json())
                        .then(d => {
                            municipioSelect.innerHTML = '<option value="">Seleccionar Municipio...</option>';
                            d.forEach(i => municipioSelect.innerHTML += `<option value="${i.id_municipio}">${i.municipio}</option>`);
                        })
                        .catch(e => console.error('Error loading municipios:', e));
                } else {
                    ciudadSelect.innerHTML = '<option value="">Selecciona un estado...</option>';
                    municipioSelect.innerHTML = '<option value="">Selecciona un estado...</option>';
                }
            });

            document.getElementById('municipio_id').addEventListener('change', function () {
                const municipioId = this.value;
                const parroquiaSelect = document.getElementById('parroquia_id');

                parroquiaSelect.innerHTML = '<option value="">Cargando...</option>';

                if (municipioId) {
                    fetch(`{{ url('ubicacion/get-parroquias') }}/${municipioId}`)
                        .then(r => r.json())
                        .then(d => {
                            parroquiaSelect.innerHTML = '<option value="">Seleccionar Parroquia...</option>';
                            d.forEach(i => parroquiaSelect.innerHTML += `<option value="${i.id_parroquia}">${i.parroquia}</option>`);
                        })
                        .catch(e => console.error('Error loading parroquias:', e));
                } else {
                    parroquiaSelect.innerHTML = '<option value="">Selecciona un municipio...</option>';
                }
            });

            // --- Security Questions Logic ---
            // Dynamic Disabling of Selected Options
            function updateQuestionOptions() {
                const selects = [
                    document.getElementById('pregunta_seguridad_1'),
                    document.getElementById('pregunta_seguridad_2'),
                    document.getElementById('pregunta_seguridad_3')
                ];

                // Get currently selected values
                const selectedValues = selects.map(s => s.value).filter(val => val !== "");

                selects.forEach(select => {
                    const currentVal = select.value;
                    const options = select.querySelectorAll('option');

                    options.forEach(option => {
                        if (option.value === "") return;

                        // If selected elsewhere AND not self, disable
                        if (selectedValues.includes(option.value) && option.value !== currentVal) {
                            option.disabled = true;
                            option.innerText = option.innerText.replace(' (Seleccionado)', '') + ' (Seleccionado)';
                        } else {
                            option.disabled = false;
                            option.innerText = option.innerText.replace(' (Seleccionado)', '');
                        }
                    });
                });
            }

            // Attach listener to question selects
            for (let i = 1; i <= 3; i++) {
                const el = document.getElementById(`pregunta_seguridad_${i}`);
                if (el) el.addEventListener('change', updateQuestionOptions);
            }

        </script>
    @endpush

    @push('styles')
        <style>
            .form-step.animate-fade-in {
                animation: fadeIn 0.4s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            input:focus,
            select:focus,
            textarea:focus {
                transform: translateY(-1px);
            }
        </style>
    @endpush
@endsection
             <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                 <div>
                     <label for="parroquia_id" class="block text-sm font-medium text-slate-700">Parroquia</label>
                     <select name="parroquia_id" id="parroquia_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                         <option value="">Primero selecciona municipio...</option>
                     </select>
                </div>
                 <div>
                     <label for="direccion" class="block text-sm font-medium text-slate-700">Dirección Exacta</label>
                     <input type="text" name="direccion" id="direccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Av. Ppal, Edif. A, Apto 1" value="{{ old('direccion') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Paso 3: Seguridad -->
    <div id="step-3" class="form-step hidden animate-fade-in">
        <div class="space-y-6">
            <div>
                <label for="correo" class="block text-sm font-medium text-slate-700">Correo Electrónico *</label>
                <input type="email" name="correo" id="correo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('correo') border-red-500 @enderror" required placeholder="ejemplo@email.com" value="{{ old('correo') }}">
                <span id="error-correo" class="text-xs text-red-600 mt-1 hidden"></span>
                @error('correo')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Contraseña *</label>
                    <div class="mb-2">
                        <p class="text-xs text-slate-500 mb-1">La contraseña debe contener:</p>
                        <ul class="text-xs space-y-1 text-slate-500 pl-1">
                            <li id="req-length"><i class="bi bi-circle"></i> Mínimo 8 caracteres</li>
                            <li id="req-upper"><i class="bi bi-circle"></i> Al menos una mayúscula</li>
                            <li id="req-number"><i class="bi bi-circle"></i> Al menos un número</li>
                            <li id="req-symbol"><i class="bi bi-circle"></i> Al menos un símbolo (@$!%*#?&.)</li>
                        </ul>
                    </div>
                    <div class="relative mt-1">
                        <input type="password" name="password" id="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10 @error('password') border-red-500 @enderror" required placeholder="Tu contraseña segura">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="togglePassword1">
                             <i class="bi bi-eye text-gray-400"></i>
                         </div>
                    </div>
                     
                     <!-- Strength Meter -->
                     <div class="mt-2">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-500" id="strength-text">Fuerza: Sin contraseña</span>
                            <span class="text-xs text-gray-400" id="strength-score">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div id="strength-bar" class="bg-red-500 h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                     </div>
                     
                     <span id="error-password" class="text-xs text-red-600 mt-1 hidden"></span>
                     @error('password')<span class="text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
                </div>
                 <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Repetir Contraseña *</label>
                    <div class="relative mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10" required placeholder="Confirmar contraseña">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="togglePassword2">
                             <i class="bi bi-eye text-gray-400"></i>
                         </div>
                    </div>
                    <span id="error-password_confirmation" class="text-xs text-red-600 mt-1 hidden"></span>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h4 class="text-sm font-semibold text-blue-800 mb-3">Preguntas de recuperación</h4>
                <div class="space-y-3">
                     @for($i = 1; $i <= 3; $i++)
                        <div>
                             <select name="pregunta_seguridad_{{ $i }}" id="pregunta_seguridad_{{ $i }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2" required>
                                 <option value="">Seleccionar pregunta {{ $i }}...</option>
                                  @foreach($preguntas ?? [] as $pregunta)
                                    <option value="{{ $pregunta->id }}" {{ old("pregunta_seguridad_$i") == $pregunta->id ? 'selected' : '' }}>{{ $pregunta->pregunta }}</option>
                                @endforeach
                             </select>
                             <input type="text" name="respuesta_seguridad_{{ $i }}" id="respuesta_seguridad_{{ $i }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2" placeholder="Respuesta" required value="{{ old("respuesta_seguridad_$i") }}">
                             <span id="error-pregunta_seguridad_{{ $i }}" class="text-xs text-red-600 mt-1 hidden"></span>
                        </div>
                     @endfor
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terminos" name="terminos" type="checkbox" required class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="terminos" class="font-medium text-slate-700">Acepto los términos y condiciones</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between pt-6 border-t border-gray-100 items-center">
        <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-medical-600 font-medium transition-colors">
            <i class="bi bi-arrow-left"></i> Volver al Login
        </a>
        
        <div class="flex gap-3">
            <button type="button" id="prevBtn" class="hidden px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="window.changeStep(-1)">
                Anterior
            </button>
            
            <button type="button" id="nextBtn" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="window.changeStep(1)">
                Siguiente <i class="bi bi-arrow-right ml-2"></i>
            </button>
            
            <button type="submit" id="submitBtn" class="hidden px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Crear Cuenta <i class="bi bi-check-lg ml-2"></i>
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script type="module">
    import { preventInvalidInput, validatePassword } from '{{ asset("js/validators.js") }}';
    import { showToast, shakeElement } from '{{ asset("js/alerts.js") }}';

    window.checkPasswordStrength = validatePassword;

    window.currentStep = 1;
    window.totalSteps = 3;

    // Estado global de validaciones asíncronas
    window.asyncValidations = {
        documento: false, // false = no validado o inválido, true = válido
        correo: false
    };

    // --- APPLY REAL-TIME BLOCKING ---
    document.addEventListener('DOMContentLoaded', () => {
        // Nombres (Texto estricto)
        ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido'].forEach(id => {
            const el = document.getElementById(id);
            if(el) preventInvalidInput(el, 'text');
        });

        // Números (Cédula, Teléfono)
        ['numero_documento', 'numero_tlf'].forEach(id => {
            const el = document.getElementById(id);
            if(el) preventInvalidInput(el, 'numbers');
        });

        // Email (Sin espacios)
        const emailEl = document.getElementById('correo');
        if(emailEl) preventInvalidInput(emailEl, 'email');
    });

    window.checkPasswordStrength = function(password) {
        const hasUpperCase = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSymbol = /[@$!%*#?&.]/.test(password);
        const minLength = password.length >= 8;

        let score = 0;
        if(minLength) score++;
        if(hasUpperCase) score++;
        if(hasNumber) score++;
        if(hasSymbol) score++;

        return {
            valid: hasUpperCase && hasNumber && hasSymbol && minLength,
            score: score,
            requirements: {
                length: minLength,
                upper: hasUpperCase,
                number: hasNumber,
                symbol: hasSymbol
            }
        };
    };

    document.addEventListener('DOMContentLoaded', () => {
        // --- VALIDACIÓN DE EDAD ---
        const fechaNacInput = document.getElementById('fecha_nac');
        const labelEdad = document.getElementById('label-edad');

        if(fechaNacInput && labelEdad) {
            fechaNacInput.addEventListener('change', () => {
                const fechaNac = new Date(fechaNacInput.value);
                const hoy = new Date();
                let edad = hoy.getFullYear() - fechaNac.getFullYear();
                const m = hoy.getMonth() - fechaNac.getMonth();
                
                if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
                    edad--;
                }

                if (isNaN(edad)) {
                    labelEdad.className = "text-xs text-slate-500 font-medium mt-1 block";
                    return;
                }

                if (edad >= 18) {
                    labelEdad.className = "text-xs text-green-600 font-medium mt-1 block";
                    labelEdad.innerHTML = `<i class="bi bi-check-circle-fill"></i> Edad válida (${edad} años)`;
                } else {
                    labelEdad.className = "text-xs text-red-600 font-medium mt-1 block";
                    labelEdad.innerHTML = `<i class="bi bi-x-circle-fill"></i> Debes ser mayor de edad`;
                    showToast('warning', 'Debes ser mayor de edad para registrarte', 4000);
                }
            });
        }

        // --- VALIDACIÓN DE DOCUMENTO AJAX ---
        const tipoDocInput = document.getElementById('tipo_documento');
        const numDocInput = document.getElementById('numero_documento');

        async function validarDocumento() {
            const tipo = tipoDocInput.value;
            const numero = numDocInput.value;

            if(!numero) {
                window.asyncValidations.documento = false;
                return false; 
            }

            // Set loading state if needed here
            
            try {
                const response = await fetch('{{ route("validate.document") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ tipo: tipo, numero: numero })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                
                if(data.exists) {
                    showError('numero_documento', 'Documento ya registrado');
                    showToast('error', 'Este número de documento ya está registrado');
                    window.asyncValidations.documento = false;
                    return false;
                } else {
                    clearError('numero_documento');
                    window.asyncValidations.documento = true;
                    return true;
                }
            } catch (error) {
                console.error('Error validando documento:', error);
                // On error, let's assume false to be safe, but maybe allow user to retry?
                // Or if it's 500, we might be blocking valid users. 
                // Decision: Block and warn.
                showToast('error', 'Error verificando documento. Intente nuevamente.');
                return false;
            }
        }

        if(tipoDocInput && numDocInput) {
            tipoDocInput.addEventListener('change', validarDocumento);
            numDocInput.addEventListener('blur', validarDocumento);
            numDocInput.addEventListener('input', () => {
                clearError('numero_documento'); 
                window.asyncValidations.documento = false; 
            });
        }

        // --- VALIDACIÓN DE CORREO AJAX ---
        const correoInput = document.getElementById('correo');
        
        async function validarCorreo() {
            const correo = correoInput.value;
            // Basic regex check first
            if(!correo || !validateField('correo', correo, 'input')) return false; 

            try {
                const response = await fetch('{{ route("validate.email") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email: correo })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if(data.exists) {
                    showError('correo', 'Correo ya registrado');
                    showToast('error', 'Este correo electrónico ya está en uso');
                    window.asyncValidations.correo = false;
                    return false;
                } else {
                    clearError('correo');
                    window.asyncValidations.correo = true;
                    return true;
                }
            } catch (error) {
                console.error('Error validando correo:', error);
                 showToast('error', 'Error verificando correo. Intente nuevamente.');
                 return false;
            }
        }

        if(correoInput) {
            correoInput.addEventListener('blur', validarCorreo);
            correoInput.addEventListener('input', () => {
                 clearError('correo');
                 window.asyncValidations.correo = false;
            });
        }

        // Expose functions globally for validateStep
        window.validarDocumento = validarDocumento;
        window.validarCorreo = validarCorreo;

        // Password logic
        const passInput = document.getElementById('password');
        if(passInput) {
            passInput.addEventListener('input', function() {
                const val = this.value;
                const result = window.checkPasswordStrength(val);
                
                // Update UI Requirements
                updateRequirement('req-length', result.requirements.length);
                updateRequirement('req-upper', result.requirements.upper);
                updateRequirement('req-number', result.requirements.number);
                updateRequirement('req-symbol', result.requirements.symbol);

                // Update Meter
                const bar = document.getElementById('strength-bar');
                const text = document.getElementById('strength-text');
                const scoreText = document.getElementById('strength-score');
                
                if(bar && text && scoreText) {
                    const pct = (result.score / 4) * 100;
                    bar.style.width = pct + '%';
                    scoreText.textContent = pct + '%';
                    
                    if(result.score <= 1) {
                        bar.className = 'bg-red-500 h-1.5 rounded-full transition-all duration-300';
                        text.textContent = 'Fuerza: Débil';
                    } else if(result.score <= 3) {
                         bar.className = 'bg-yellow-500 h-1.5 rounded-full transition-all duration-300';
                         text.textContent = 'Fuerza: Media';
                    } else {
                         bar.className = 'bg-green-500 h-1.5 rounded-full transition-all duration-300';
                         text.textContent = 'Fuerza: Segura';
                    }
                }
            });
        }

        function updateRequirement(id, met) {
            const el = document.getElementById(id);
            if(el) {
                if(met) {
                    el.classList.remove('text-slate-500');
                    el.classList.add('text-green-600', 'font-medium');
                    el.querySelector('i').className = 'bi bi-check-circle-fill';
                } else {
                    el.classList.add('text-slate-500');
                    el.classList.remove('text-green-600', 'font-medium');
                    el.querySelector('i').className = 'bi bi-circle';
                }
            }
        }
    });

    // Utility to show error below field
    function showError(fieldId, message) {
        const el = document.getElementById(fieldId);
        const errSpan = document.getElementById('error-' + fieldId);
        if (el) {
            el.classList.add('border-red-500', 'focus:ring-red-500');
            el.classList.remove('border-gray-300', 'focus:ring-blue-500');
            shakeElement(el);
        }
        if (errSpan) {
            errSpan.textContent = message;
            errSpan.classList.remove('hidden');
        }
    }

    function clearError(fieldId) {
        const el = document.getElementById(fieldId);
        const errSpan = document.getElementById('error-' + fieldId);
        if (el) {
            el.classList.remove('border-red-500', 'focus:ring-red-500');
            el.classList.add('border-gray-300', 'focus:ring-blue-500');
        }
        if (errSpan) {
            errSpan.classList.add('hidden');
        }
    }

    function clearAllErrors() {
        document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-gray-300');
        });
    }

    window.changeStep = async function(dir) {
        const nextStep = window.currentStep + dir;
        
        if (dir === 1) {
            // Validaciones al intentar avanzar
            const stepValid = await window.validateStep(window.currentStep);
            
            if (!stepValid) {
                showToast('error', 'Por favor corrige los errores antes de continuar', 4000);
                return;
            }
        }

        if (nextStep >= 1 && nextStep <= window.totalSteps) {
            window.showStep(nextStep);
        }
    };

    window.showStep = function(step) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.add('hidden'));
        const target = document.getElementById('step-' + step);
        if(target) target.classList.remove('hidden');

        const prev = document.getElementById('prevBtn');
        const next = document.getElementById('nextBtn');
        const submit = document.getElementById('submitBtn');

        if(prev) prev.style.display = (step === 1) ? 'none' : 'inline-flex';
        if(next) next.classList.toggle('hidden', step === window.totalSteps);
        if(submit) submit.classList.toggle('hidden', step !== window.totalSteps);

        updateIndicators(step);
        window.currentStep = step;
    };

    // Validation Rules (UPDATED: Optional Fields)
    const validationRules = {
        'primer_nombre': { required: true, regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/, msg: 'Solo letras permitidas' },
        'segundo_nombre': { required: false, regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/, msg: 'Solo letras permitidas' }, // Optional
        'primer_apellido': { required: true, regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/, msg: 'Solo letras permitidas' },
        'segundo_apellido': { required: false, regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/, msg: 'Solo letras permitidas' }, // Optional
        'numero_documento': { required: true, regex: /^\d+$/, minLen: 6, maxLen: 12, msg: 'Solo números (6-12 dígitos)' },
        'fecha_nac': { required: true, msg: 'Fecha requerida' },
        'genero': { required: true, msg: 'Seleccione una opción' },
        'numero_tlf': { required: true, regex: /^\d+$/, minLen: 10, maxLen: 15, msg: 'Solo números válidos' },
        'estado_id': { required: true, msg: 'Seleccione un estado' },
        'municipio_id': { required: true, msg: 'Seleccione un municipio' },
        'parroquia_id': { required: true, msg: 'Seleccione una parroquia' },
        'direccion': { required: true, msg: 'Dirección requerida' },
        'correo': { required: true, email: true, msg: 'Correo inválido' },
        'password': { required: true, password: true, msg: 'Verifique requisitos' },
        'password_confirmation': { required: true, match: 'password', msg: 'Las contraseñas no coinciden' },
        'pregunta_seguridad_1': { required: true, msg: 'Seleccione una pregunta' },
        'pregunta_seguridad_2': { required: true, msg: 'Seleccione una pregunta' },
        'pregunta_seguridad_3': { required: true, msg: 'Seleccione una pregunta' },
        'respuesta_seguridad_1': { required: true, msg: 'Respuesta requerida' },
        'respuesta_seguridad_2': { required: true, msg: 'Respuesta requerida' },
        'respuesta_seguridad_3': { required: true, msg: 'Respuesta requerida' }
    };

    function validateField(id, value, eventType = 'blur') {
        const rule = validationRules[id];
        if(!rule) return true;

        let valid = true;
        let errorMsg = '';

        // Input-time validation (loose format checks)
        if (eventType === 'input') {
             if (rule.regex && value && !rule.regex.test(value)) {
                valid = false;
                errorMsg = rule.msg;
            }
            if (id === 'password') return true; 
        }

        // Blur/Submit validation
        if (eventType === 'blur' || eventType === 'submit') {
            // Check Required
            if (rule.required && !value.trim()) {
                valid = false;
                errorMsg = 'Campo requerido';
            } 
            // Check content if value exists (even if optional)
            else if (value.trim()) {
                if (rule.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    valid = false;
                    errorMsg = 'Formato de correo inválido';
                } else if (rule.minLen && value.length < rule.minLen) {
                    valid = false;
                    errorMsg = `Mínimo ${rule.minLen} caracteres`;
                } else if (rule.match) {
                    const otherVal = document.getElementById(rule.match).value;
                    if (value !== otherVal) {
                        valid = false;
                        errorMsg = rule.msg;
                    }
                } else if (rule.regex && !rule.regex.test(value)) {
                     valid = false;
                     errorMsg = rule.msg;
                }
            }
        }

        if(!valid && errorMsg) {
             showError(id, errorMsg);
        } else {
             if(id !== 'numero_documento' && id !== 'correo') {
                 clearError(id);
             } else if(valid) {
                 clearError(id);
             }
        }
        return valid;
    }

    // Attach listeners
    document.addEventListener('DOMContentLoaded', () => {
        Object.keys(validationRules).forEach(id => {
            const el = document.getElementById(id);
            if(el) {
                el.addEventListener('input', (e) => validateField(id, e.target.value, 'input'));
                el.addEventListener('blur', (e) => validateField(id, e.target.value, 'blur'));
            }
        });
    });

    window.validateStep = async function(step) {
        let isValid = true;
        let idsToCheck = [];

        if (step === 1) {
            idsToCheck = ['primer_nombre', 'primer_apellido', 'numero_documento', 'fecha_nac', 'genero', 'numero_tlf'];
            // Validar opcionales solo si tienen valor
            const segNom = document.getElementById('segundo_nombre').value;
            if(segNom) idsToCheck.push('segundo_nombre');
            
            const segApe = document.getElementById('segundo_apellido').value;
            if(segApe) idsToCheck.push('segundo_apellido');
            
        } else if (step === 2) {
             idsToCheck = ['estado_id', 'municipio_id', 'parroquia_id', 'direccion'];
        } else if (step === 3) {
             idsToCheck = ['correo', 'password', 'password_confirmation', 
                           'pregunta_seguridad_1', 'respuesta_seguridad_1',
                           'pregunta_seguridad_2', 'respuesta_seguridad_2',
                           'pregunta_seguridad_3', 'respuesta_seguridad_3'];
        }

        // Sync checks
        idsToCheck.forEach(id => {
            const el = document.getElementById(id);
            if(el) {
                if(!validateField(id, el.value, 'submit')) {
                    isValid = false;
                }
            }
        });

        // Step 1 Checks (Age & Async Document)
        if (step === 1) {
            // Age Check
            const fechaNac = document.getElementById('fecha_nac').value;
            if(fechaNac) {
                const hoy = new Date();
                const nac = new Date(fechaNac);
                let edad = hoy.getFullYear() - nac.getFullYear();
                const m = hoy.getMonth() - nac.getMonth();
                if (m < 0 || (m === 0 && hoy.getDate() < nac.getDate())) edad--;
                
                if(edad < 18) {
                    isValid = false;
                    showToast('error', 'Debes ser mayor de edad para registrarte');
                }
            }

            // Async Document Check
            // If already true, good. If false/undefined, we force check.
            const docVal = document.getElementById('numero_documento').value;
             if (docVal && !window.asyncValidations.documento) {
                 // Force check
                 const valid = await window.validarDocumento();
                 if(!valid) isValid = false;
            }
        }

        // Step 2... (Checking if fields are valid done by loop)

        // Step 3 Checks (Password Strength, Terms, Async Email)
        if (step === 3) {
             const p1 = document.getElementById('password').value;
             const strength = window.checkPasswordStrength(p1);
             if (!strength.valid) {
                 isValid = false;
                 showError('password', 'Contraseña débil');
             }

             // Terms Check
             const terms = document.getElementById('terminos');
             if (terms && !terms.checked) {
                 isValid = false;
                 showToast('warning', 'Debes aceptar los términos y condiciones', 4000);
                 shakeElement(terms.parentElement);
             }

             // Async Email Check
             // Force valid check if not yet confirmed
             const emailVal = document.getElementById('correo').value;
             if (emailVal && !window.asyncValidations.correo) {
                 const valid = await window.validarCorreo();
                 if(!valid) isValid = false;
             }
        }

        return isValid;
    };

    // Intercept submit for final validation
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        console.log('Submit button clicked!'); // Debug
        
        const btn = document.getElementById('submitBtn');
        const originalContent = btn.innerHTML;
        
        // Disable button and show loading
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Procesando...';

        const p1 = document.getElementById('password').value;
        const p2 = document.getElementById('password_confirmation').value;

        // Check password match
        if (p1 !== p2) {
            console.error('Passwords do not match');
            showToast('error', 'Las contraseñas no coinciden');
            btn.disabled = false;
            btn.innerHTML = originalContent;
            return;
        }

        // Check terms
        const terms = document.getElementById('terminos');
        if (!terms.checked) {
            console.error('Terms not accepted');
            showToast('warning', 'Debes aceptar los términos y condiciones');
            btn.disabled = false;
            btn.innerHTML = originalContent;
            return;
        }

        // Simple password strength check
        if (p1.length < 8) {
            console.error('Password too short');
            showToast('warning', 'La contraseña debe tener al menos 8 caracteres');
            btn.disabled = false;
            btn.innerHTML = originalContent;
            return;
        }

        console.log('All validations passed, submitting form...');
        
        // Submit the form
        this.submit();
    });

    function updateIndicators(step) {
        for(let i=1; i<=3; i++) {
            const ind = document.getElementById('ind-' + i);
            const txt = document.getElementById('text-' + i);
            if(!ind) continue;
            
            ind.className = "w-10 h-10 rounded-full flex items-center justify-center font-bold ring-4 ring-white transition-all duration-300 border-2";
            
            if (i < step) {
                // Completado
                ind.classList.add('bg-green-600', 'text-white', 'border-transparent');
                ind.classList.remove('bg-blue-600', 'bg-gray-100', 'text-gray-400', 'text-blue-600');
                ind.innerHTML = '<i class="bi bi-check-lg"></i>';
                if(txt) txt.classList.replace('text-gray-400', 'text-green-600');
            } else if (i === step) {
                // Actual
                ind.classList.add('bg-blue-600', 'text-white', 'border-transparent', 'shadow-md');
                ind.innerHTML = i;
                if(txt) txt.classList.add('text-blue-600');
            } else {
                ind.classList.add('bg-gray-100', 'text-gray-400', 'border-transparent');
                ind.innerHTML = i;
                if(txt) txt.classList.add('text-gray-400');
            }
        }
    }

    // Security questions: prevent duplicates
    document.addEventListener('DOMContentLoaded', () => {
        const selects = [
            document.getElementById('pregunta_seguridad_1'),
            document.getElementById('pregunta_seguridad_2'),
            document.getElementById('pregunta_seguridad_3')
        ];

        function updateSelects() {
            const selectedValues = selects.map(s => s ? s.value : '').filter(v => v);
            
            selects.forEach(select => {
                if (!select) return;
                Array.from(select.options).forEach(option => {
                    if (selectedValues.includes(option.value) && select.value !== option.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        selects.forEach(select => {
            if(select) select.addEventListener('change', updateSelects);
        });
        updateSelects();

        // Password toggle
        const togglePassword = (input, toggle) => {
            if (!input || !toggle) return;
            toggle.addEventListener('click', () => {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                toggle.querySelector('i').classList.toggle('bi-eye');
                toggle.querySelector('i').classList.toggle('bi-eye-slash');
            });
        };

        togglePassword(document.getElementById('password'), document.getElementById('togglePassword1'));
        togglePassword(document.getElementById('password_confirmation'), document.getElementById('togglePassword2'));

        // Only allow numbers in cedula and phone
        ['numero_documento', 'numero_tlf'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', (e) => {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            }
        });
    });

    // Location Logic
    document.addEventListener('DOMContentLoaded', () => {
        const estado = document.getElementById('estado_id');
        const ciudad = document.getElementById('ciudad_id');
        const municipio = document.getElementById('municipio_id');
        const parroquia = document.getElementById('parroquia_id');

        async function loadSelect(url, el, valueKey, textKey) {
            if(!el) return;
            el.innerHTML = '<option value="">Cargando...</option>';
            try {
                const res = await fetch(url);
                const data = await res.json();
                el.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item[valueKey];
                    opt.textContent = item[textKey];
                    el.appendChild(opt);
                });
            } catch(e) {
                console.error(e);
                el.innerHTML = '<option value="">Error al cargar</option>';
            }
        }

        if(estado) {
            estado.addEventListener('change', () => {
                if(estado.value) {
                    loadSelect('{{ url("ubicacion/get-ciudades") }}/' + estado.value, ciudad, 'id_ciudad', 'ciudad');
                    loadSelect('{{ url("ubicacion/get-municipios") }}/' + estado.value, municipio, 'id_municipio', 'municipio');
                    if(parroquia) parroquia.innerHTML = '<option value="">Primero selecciona municipio...</option>';
                }
            });
        }

        if(municipio) {
            municipio.addEventListener('change', () => {
                if(municipio.value) {
                    loadSelect('{{ url("ubicacion/get-parroquias") }}/' + municipio.value, parroquia, 'id_parroquia', 'parroquia');
                }
            });
        }
    });
</script>
@endpush
@endsection
