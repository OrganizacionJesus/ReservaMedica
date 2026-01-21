@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600';
    $baseColorClass = str_contains($bannerColor, 'from-') ? $bannerColor : '';
    $baseColorStyle = str_contains($bannerColor, '#') ? 'background-color: ' . $bannerColor : '';
@endphp

@section('title', 'Nuevo Administrador')

@section('content')
<!-- Hero Banner -->
<div class="relative overflow-hidden rounded-[2rem] {{ $baseColorClass }} shadow-2xl mb-8" 
     style="{{ $baseColorStyle }}; min-height: 160px;">
     
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600"></div>
    @endif
    
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/15 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-slow"></div>
    
    <div class="relative z-10 p-6 flex items-center gap-4">
        <a href="{{ route('administradores.index') }}" 
           class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl flex items-center justify-center text-white border border-white/30 transition-all hover:scale-110">
            <i class="bi bi-arrow-left text-lg"></i>
        </a>
        <div class="text-white" style="color: var(--text-on-medical, #ffffff);">
            <h1 class="text-3xl font-black mb-1" style="text-shadow: 0 2px 10px rgba(0,0,0,0.15);">
                Crear Nuevo Administrador
            </h1>
            <p class="text-white/90 text-sm font-medium" style="opacity: 0.95;">
                Completa los datos del nuevo administrador del sistema
            </p>
        </div>
    </div>
</div>

<form id="createAdminForm" method="POST" action="{{ route('administradores.store') }}">
    @csrf
    <input type="hidden" name="tipo_admin" value="Administrador">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Personal -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-indigo-300 to-purple-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        Información Personal
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Primer Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="primer_nombre" id="primer_nombre"
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   value="{{ old('primer_nombre') }}" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Segundo Nombre</label>
                            <input type="text" name="segundo_nombre" id="segundo_nombre"
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   value="{{ old('segundo_nombre') }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Primer Apellido <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="primer_apellido" id="primer_apellido"
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   value="{{ old('primer_apellido') }}" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Segundo Apellido</label>
                            <input type="text" name="segundo_apellido" id="segundo_apellido"
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   value="{{ old('segundo_apellido') }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Cédula <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <select name="tipo_documento" id="tipo_documento"
                                        class="w-24 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-bold" 
                                        required>
                                    <option value="V" {{ old('tipo_documento') == 'V' ? 'selected' : '' }}>V</option>
                                    <option value="E" {{ old('tipo_documento') == 'E' ? 'selected' : '' }}>E</option>
                                    <option value="P" {{ old('tipo_documento') == 'P' ? 'selected' : '' }}>P</option>
                                    <option value="J" {{ old('tipo_documento') == 'J' ? 'selected' : '' }}>J</option>
                                </select>
                                <input type="text" name="numero_documento" id="numero_documento"
                                       class="flex-1 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       placeholder="12345678" value="{{ old('numero_documento') }}" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Fecha de Nacimiento <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_nac" id="fecha_nac"
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   value="{{ old('fecha_nac') }}" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Género <span class="text-red-500">*</span>
                            </label>
                            <select name="genero" id="genero"
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    required>
                                <option value="">Seleccionar...</option>
                                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <select name="prefijo_tlf" id="prefijo_tlf"
                                        class="w-24 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-bold" 
                                        required>
                                    <option value="+58" {{ old('prefijo_tlf') == '+58' ? 'selected' : '' }}>+58</option>
                                    <option value="+57" {{ old('prefijo_tlf') == '+57' ? 'selected' : '' }}>+57</option>
                                    <option value="+1" {{ old('prefijo_tlf') == '+1' ? 'selected' : '' }}>+1</option>
                                </select>
                                <input type="text" name="numero_tlf" id="numero_tlf"
                                       class="flex-1 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       placeholder="412-1234567" value="{{ old('numero_tlf') }}" required>
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
                                    <option value="{{ $estado->id_estado }}" {{ old('estado_id') == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Ciudad</label>
                            <select name="ciudad_id" id="ciudad_id"
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    disabled>
                                <option value="">Seleccione un Estado primero</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Municipio</label>
                            <select name="municipio_id" id="municipio_id"
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    disabled>
                                <option value="">Seleccione un Estado primero</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Parroquia</label>
                            <select name="parroquia_id" id="parroquia_id"
                                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                    disabled>
                                <option value="">Seleccione un Municipio primero</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Dirección Detallada</label>
                            <textarea name="direccion_detallada" id="direccion_detallada"
                                      class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium resize-none" 
                                      rows="2" placeholder="Av. Principal, Edificio...">{{ old('direccion_detallada') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Credenciales -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-300 via-green-300 to-teal-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        Credenciales de Acceso
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="correo" id="correo"
                                   class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                   placeholder="admin@ejemplo.com" value="{{ old('correo') }}" required>
                            <p class="text-xs text-gray-500 mt-1 font-medium">Este correo se usará para acceder al sistema</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       placeholder="Mínimo 8 caracteres" required>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">
                                    Confirmar <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                                       placeholder="Repetir contraseña" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estado -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-300 via-pink-300 to-rose-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4">Estado</h3>
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200/60 rounded-2xl cursor-pointer hover:bg-white/70 transition-all">
                        <input type="checkbox" name="status" value="1" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 focus:ring-4 rounded" checked>
                        <div>
                            <p class="font-black text-gray-900">Administrador Activo</p>
                            <p class="text-sm text-gray-600 font-medium">Tendrá acceso al sistema</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Consultorios -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-cyan-300 to-teal-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                        <i class="bi bi-building text-teal-600"></i>
                        Consultorios Asignados
                    </h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($consultorios as $consultorio)
                            <label class="flex items-center gap-3 p-3 border-2 border-gray-200/60 rounded-xl cursor-pointer hover:bg-white/70 hover:border-teal-300 transition-all">
                                <input type="checkbox" name="consultorios[]" value="{{ $consultorio->id }}" 
                                       class="w-5 h-5 text-teal-600 focus:ring-teal-500 focus:ring-4 rounded"
                                       {{ in_array($consultorio->id, old('consultorios', [])) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 font-bold">{{ $consultorio->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-3 font-medium">Solo podrá gestionar estos consultorios</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-300 via-green-300 to-teal-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
                <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                    <h3 class="text-lg font-black text-gray-900 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-check-lg text-lg"></i>
                            Crear Administrador
                        </button>
                        <a href="{{ route('administradores.index') }}" 
                           class="w-full px-6 py-4 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 hover:border-gray-300 text-gray-700 font-black rounded-2xl shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-x-lg"></i>
                            Cancelar
                        </a>
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
    
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(243, 244, 246, 0.5); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(20, 184, 166, 0.6), rgba(13, 148, 136, 0.8)); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, rgba(20, 184, 166, 0.8), rgba(13, 148, 136, 1)); }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const estadoSelect = document.getElementById('estado_id');
    const ciudadSelect = document.getElementById('ciudad_id');
    const municipioSelect = document.getElementById('municipio_id');
    const parroquiaSelect = document.getElementById('parroquia_id');

    if(estadoSelect) {
        estadoSelect.addEventListener('change', function() {
            const estadoId = this.value;
            ciudadSelect.innerHTML = '<option value="">Cargando...</option>';
            municipioSelect.innerHTML = '<option value="">Cargando...</option>';
            parroquiaSelect.innerHTML = '<option value="">Seleccione un Municipio primero</option>';
            ciudadSelect.disabled = true;
            municipioSelect.disabled = true;
            parroquiaSelect.disabled = true;

            if (estadoId) {
                fetch(`{{ url('admin/get-ciudades') }}/${estadoId}`)
                    .then(r => r.json())
                    .then(d => {
                        ciudadSelect.innerHTML = '<option value="">Seleccionar Ciudad...</option>';
                        d.forEach(i => ciudadSelect.innerHTML += `<option value="${i.id_ciudad}">${i.ciudad}</option>`);
                        ciudadSelect.disabled = false;
                    });

                fetch(`{{ url('admin/get-municipios') }}/${estadoId}`)
                    .then(r => r.json())
                    .then(d => {
                        municipioSelect.innerHTML = '<option value="">Seleccionar Municipio...</option>';
                        d.forEach(i => municipioSelect.innerHTML += `<option value="${i.id_municipio}">${i.municipio}</option>`);
                        municipioSelect.disabled = false;
                    });
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
                fetch(`{{ url('admin/get-parroquias') }}/${municipioId}`)
                    .then(r => r.json())
                    .then(d => {
                        parroquiaSelect.innerHTML = '<option value="">Seleccionar Parroquia...</option>';
                        d.forEach(i => parroquiaSelect.innerHTML += `<option value="${i.id_parroquia}">${i.parroquia}</option>`);
                        parroquiaSelect.disabled = false;
                    });
            } else {
                parroquiaSelect.innerHTML = '<option value="">Seleccione un Municipio primero</option>';
            }
        });
    }
});
</script>
@endpush
@endsection
