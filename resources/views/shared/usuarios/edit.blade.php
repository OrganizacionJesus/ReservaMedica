@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-br from-amber-500 via-orange-600 to-red-600';
    $baseColorClass = str_contains($bannerColor, 'from-') ? $bannerColor : '';
    $baseColorStyle = str_contains($bannerColor, '#') ? 'background-color: ' . $bannerColor : '';
    $perfil = $usuario->administrador ?? $usuario->medico ?? $usuario->paciente;
@endphp

@section('title', 'Editar Usuario')

@section('content')
<!-- Hero Banner -->
<div class="relative overflow-hidden rounded-[2rem] {{ $baseColorClass }} shadow-2xl mb-8" 
     style="{{ $baseColorStyle }}; min-height: 160px;">
     
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 via-orange-600 to-red-600"></div>
    @endif
    
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/15 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-slow"></div>
    
    <div class="relative z-10 p-6 flex items-center gap-4">
        <a href="{{ route('usuarios.index') }}" 
           class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl flex items-center justify-center text-white border border-white/30 transition-all hover:scale-110">
            <i class="bi bi-arrow-left text-lg"></i>
        </a>
        <div class="text-white" style="color: var(--text-on-medical, #ffffff);">
            <h1 class="text-3xl font-black mb-1" style="text-shadow: 0 2px 10px rgba(0,0,0,0.15);">
                Editar Usuario
            </h1>
            <p class="text-white/90 text-sm font-medium" style="opacity: 0.95;">
                Actualizar información del usuario
            </p>
        </div>
    </div>
</div>

<form id="editUserForm" action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Personal -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-indigo-300 to-purple-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-person"></i>
                        </div>
                        Información Personal
                    </h3>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                    Primer Nombre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="primer_nombre" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       value="{{ old('primer_nombre', $perfil->primer_nombre ?? '') }}" required>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Segundo Nombre</label>
                                <input type="text" name="segundo_nombre" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       value="{{ old('segundo_nombre', $perfil->segundo_nombre ?? '') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                    Primer Apellido <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="primer_apellido" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       value="{{ old('primer_apellido', $perfil->primer_apellido ?? '') }}" required>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Segundo Apellido</label>
                                <input type="text" name="segundo_apellido" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       value="{{ old('segundo_apellido', $perfil->segundo_apellido ?? '') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                    Cédula <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <select name="tipo_documento" 
                                            class="w-24 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-bold" 
                                            required>
                                        <option value="V" {{ old('tipo_documento', $perfil->tipo_documento ?? '') == 'V' ? 'selected' : '' }}>V</option>
                                        <option value="E" {{ old('tipo_documento', $perfil->tipo_documento ?? '') == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="P" {{ old('tipo_documento', $perfil->tipo_documento ?? '') == 'P' ? 'selected' : '' }}>P</option>
                                        <option value="J" {{ old('tipo_documento', $perfil->tipo_documento ?? '') == 'J' ? 'selected' : '' }}>J</option>
                                    </select>
                                    <input type="text" name="numero_documento" 
                                           class="flex-1 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                           placeholder="12345678" value="{{ old('numero_documento', $perfil->numero_documento ?? '') }}" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       value="{{ old('fecha_nacimiento', $perfil->fecha_nac ?? '') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Género</ label>
                                <select name="genero" 
                                        class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium">
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('genero', $perfil->genero ?? '') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero', $perfil->genero ?? '') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Teléfono</label>
                                <div class="flex gap-2">
                                    <select name="prefijo_tlf" 
                                            class="w-24 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-bold">
                                        <option value="+58" {{ old('prefijo_tlf', $perfil->prefijo_tlf ?? '') == '+58' ? 'selected' : '' }}>+58</option>
                                        <option value="+57" {{ old('prefijo_tlf', $perfil->prefijo_tlf ?? '') == '+57' ? 'selected' : '' }}>+57</option>
                                        <option value="+1" {{ old('prefijo_tlf', $perfil->prefijo_tlf ?? '') == '+1' ? 'selected' : '' }}>+1</option>
                                        <option value="+34" {{ old('prefijo_tlf', $perfil->prefijo_tlf ?? '') == '+34' ? 'selected' : '' }}>+34</option>
                                    </select>
                                    <input type="tel" name="telefono" 
                                           class="flex-1 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                           placeholder="412-1234567" value="{{ old('telefono', $perfil->numero_tlf ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ubicación -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-rose-300 via-pink-300 to-red-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        Información de Ubicación
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Estado</label>
                            <select name="estado_id" id="estado_id" 
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium">
                                <option value="">Seleccionar Estado...</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" {{ old('estado_id', $perfil->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Ciudad</label>
                            <select name="ciudad_id" id="ciudad_id" 
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    {{ empty($perfil->estado_id) ? 'disabled' : '' }}>
                                <option value="">{{ empty($perfil->estado_id) ? 'Seleccione un Estado primero' : 'Cargando/Seleccionar...' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Municipio</label>
                            <select name="municipio_id" id="municipio_id" 
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    {{ empty($perfil->estado_id) ? 'disabled' : '' }}>
                                <option value="">{{ empty($perfil->estado_id) ? 'Seleccione un Estado primero' : 'Cargando/Seleccionar...' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Parroquia</label>
                            <select name="parroquia_id" id="parroquia_id" 
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    {{ empty($perfil->municipio_id) ? 'disabled' : '' }}>
                                <option value="">{{ empty($perfil->municipio_id) ? 'Seleccione un Municipio primero' : 'Cargando/Seleccionar...' }}</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Dirección Detallada</label>
                            <textarea name="direccion_detallada" 
                                      class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium resize-none" 
                                      rows="2" placeholder="Av. Principal...">{{ old('direccion_detallada', $perfil->direccion_detallada ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @if($usuario->medico)
            <!-- Campos Específicos: Médico -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-300 via-purple-300 to-blue-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        Información Profesional (Médico)
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Nro. Colegiatura</label>
                            <input type="text" name="nro_colegiatura" 
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   placeholder="MPPS-12345" value="{{ old('nro_colegiatura', $perfil->nro_colegiatura ?? '') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Formación Académica</label>
                            <textarea name="formacion_academica" 
                                      class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium resize-none" 
                                      rows="2" placeholder="Universidad, Especializaciones...">{{ old('formacion_academica', $perfil->formacion_academica ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Experiencia Profesional</label>
                            <textarea name="experiencia_profesional" 
                                      class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium resize-none" 
                                      rows="2" placeholder="Experiencia previa...">{{ old('experiencia_profesional', $perfil->experiencia_profesional ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($usuario->paciente)
            <!-- Campos Específicos: Paciente -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-300 via-cyan-300 to-blue-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-person-heart"></i>
                        </div>
                        Información Adicional (Paciente)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Ocupación</label>
                            <input type="text" name="ocupacion" 
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   placeholder="Estudiante, Ingeniero..." value="{{ old('ocupacion', $perfil->ocupacion ?? '') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Estado Civil</label>
                            <select name="estado_civil" 
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium">
                                <option value="">Seleccionar...</option>
                                <option value="Soltero" {{ old('estado_civil', $perfil->estado_civil ?? '') == 'Soltero' ? 'selected' : '' }}>Soltero</option>
                                <option value="Casado" {{ old('estado_civil', $perfil->estado_civil ?? '') == 'Casado' ? 'selected' : '' }}>Casado</option>
                                <option value="Divorciado" {{ old('estado_civil', $perfil->estado_civil ?? '') == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                                <option value="Viudo" {{ old('estado_civil', $perfil->estado_civil ?? '') == 'Viudo' ? 'selected' : '' }}>Viudo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Credenciales -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-300 via-green-300 to-teal-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        Credenciales de Acceso
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Email</label>
                            <input type="email" 
                                   class="w-full px-4 py-3 bg-gray-100/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl text-gray-500 cursor-not-allowed font-medium" 
                                   value="{{ $usuario->correo }}" 
                                   readonly disabled>
                            <p class="text-xs text-gray-400 mt-1 font-medium">El correo no es modificable</p>
                        </div>

                        <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-2xl mb-4">
                            <div class="flex items-start gap-3">
                                <i class="bi bi-info-circle text-yellow-600 text-xl mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-black text-yellow-800">Cambio de Contraseña</p>
                                    <p class="text-sm text-yellow-700 font-medium">Deje los campos de contraseña en blanco si no desea cambiarla.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Nueva Contraseña</label>
                                <input type="password" name="password" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Confirmar</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Rol -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-300 via-slate-300 to-zinc-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4">Rol de Usuario</h3>
                    <div class="p-5 bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-200 rounded-2xl">
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Rol Actual</p>
                        <p class="font-black text-gray-900 text-xl mb-3">{{ $usuario->rol->nombre_rol }}</p>
                        <p class="text-xs text-gray-400 font-medium flex items-center gap-1">
                            <i class="bi bi-lock-fill"></i>
                            El rol no se puede modificar
                        </p>
                    </div>
                    <input type="hidden" name="rol_id" value="{{ $usuario->rol_id }}">
                </div>
            </div>

            <!-- Estado -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-300 via-pink-300 to-rose-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4">Estado</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border-2 border-gray-200/60 rounded-2xl cursor-pointer hover:bg-white/70 hover:border-emerald-300 transition-all">
                            <input type="radio" name="status" value="1" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 focus:ring-4" {{ old('status', $usuario->status) == 1 ? 'checked' : '' }}>
                            <div>
                                <p class="font-black text-gray-900">Activo</p>
                                <p class="text-sm text-gray-600 font-medium">Usuario habilitado</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border-2 border-gray-200/60 rounded-2xl cursor-pointer hover:bg-white/70 hover:border-red-300 transition-all">
                            <input type="radio" name="status" value="0" class="w-5 h-5 text-red-600 focus:ring-red-500 focus:ring-4" {{ old('status', $usuario->status) == 0 ? 'checked' : '' }}>
                            <div>
                                <p class="font-black text-gray-900">Inactivo</p>
                                <p class="text-sm text-gray-600 font-medium">Usuario deshabilitado</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-indigo-300 to-purple-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-black rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-check-lg text-lg"></i>
                            Guardar Cambios
                        </button>
                        <a href="{{ route('usuarios.index') }}" 
                           class="w-full px-6 py-4 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 hover:border-gray-300 text-gray-700 font-black rounded-2xl shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-x-lg"></i>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-300 via-slate-300 to-zinc-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4 text-center">Detalles</h3>
                    <div class="space-y-2 text-sm text-center">
                        <p class="text-gray-500 font-medium">Registrado el: <span class="font-black text-gray-700">{{ $usuario->created_at->format('d/m/Y') }}</span></p>
                        <p class="text-gray-500 font-medium">Últ. actualización: <span class="font-black text-gray-700">{{ $usuario->updated_at->diffForHumans() }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
    @keyframes float-orb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(40px, -60px) scale(1.15); }
        66% { transform: translate(-30px, 30px) scale(0.9); }
    }
    .animate-float-orb { animation: float-orb 20s ease-in-out infinite; }
    .animate-float-orb-slow { animation: float-orb 30s ease-in-out infinite reverse; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data for pre-filling locations
    const initialData = {
        estado_id: "{{ old('estado_id', $perfil->estado_id ?? '') }}",
        ciudad_id: "{{ old('ciudad_id', $perfil->ciudad_id ?? '') }}",
        municipio_id: "{{ old('municipio_id', $perfil->municipio_id ?? '') }}",
        parroquia_id: "{{ old('parroquia_id', $perfil->parroquia_id ?? '') }}"
    };

    // Location Logic
    const estadoSelect = document.getElementById('estado_id');
    const ciudadSelect = document.getElementById('ciudad_id');
    const municipioSelect = document.getElementById('municipio_id');
    const parroquiaSelect = document.getElementById('parroquia_id');

    // Load dependent dropdowns
    async function loadDropdowns(type, parentId, selectedId = null) {
        if (!parentId) return;
        try {
            let pluralType = type + 's';
            if (type === 'ciudad') pluralType = 'ciudades';
            
            const response = await fetch(`{{ url('ubicacion') }}/get-${pluralType}/${parentId}`);
            const data = await response.json();
            
            let targetSelect, label;
            if(type === 'ciudad') { targetSelect = ciudadSelect; label = 'Ciudad'; }
            if(type === 'municipio') { targetSelect = municipioSelect; label = 'Municipio'; }
            if(type === 'parroquia') { targetSelect = parroquiaSelect; label = 'Parroquia'; }

            targetSelect.innerHTML = `<option value="">Seleccionar ${label}...</option>`;
            data.forEach(item => {
                const id = item[`id_${type}`];
                const name = item[type];
                targetSelect.innerHTML += `<option value="${id}" ${selectedId == id ? 'selected' : ''}>${name}</option>`;
            });
            targetSelect.disabled = false;
        } catch (e) {
            console.error('Error loading location data:', e);
        }
    }

    // Initialize locations if editing existing data
    if (initialData.estado_id) {
        loadDropdowns('ciudad', initialData.estado_id, initialData.ciudad_id);
        loadDropdowns('municipio', initialData.estado_id, initialData.municipio_id);
    }
    if (initialData.municipio_id) {
        loadDropdowns('parroquia', initialData.municipio_id, initialData.parroquia_id);
    }

    if(estado Select) {
        estadoSelect.addEventListener('change', function() {
            const estadoId = this.value;
            ciudadSelect.innerHTML = '<option value="">Cargando...</option>';
            municipioSelect.innerHTML = '<option value="">Cargando...</option>';
            parroquiaSelect.innerHTML = '<option value="">Seleccione un Municipio primero</option>';
            ciudadSelect.disabled = true;
            municipioSelect.disabled = true;
            parroquiaSelect.disabled = true;

            if (estadoId) {
                loadDropdowns('ciudad', estadoId);
                loadDropdowns('municipio', estadoId);
            } else {
                ciudadSelect.innerHTML = '<option value="">Seleccione un Estado primero</option>';
                municipioSelect.innerHTML = '<option value="">Seleccione un Estado primero</option>';
            }
        });

        municipioSelect.addEventListener('change', function() {
            const municipioId = this.value;
            parroquiaSelect.innerHTML = '<option value="">Cargando...</option>';
            parroquiaSelect.disabled = true;
            if (municipioId) {
                loadDropdowns('parroquia', municipioId);
            } else {
                parroquiaSelect.innerHTML = '<option value="">Seleccione un Municipio primero</option>';
            }
        });
    }
});
</script>
@endpush
@endsection
