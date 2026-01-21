@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-br from-purple-500 via-pink-600 to-rose-600';
    $baseColorClass = str_contains($bannerColor, 'from-') ? $bannerColor : '';
    $baseColorStyle = str_contains($bannerColor, '#') ? 'background-color: ' . $bannerColor : '';
    $perfil = $usuario->administrador ?? $usuario->medico ?? $usuario->paciente;
@endphp

@section('title', 'Detalle de Usuario')

@section('content')
<!-- Hero Banner -->
<div class="relative overflow-hidden rounded-[2rem] {{ $baseColorClass }} shadow-2xl mb-8" 
     style="{{ $baseColorStyle }}; min-height: 160px;">
     
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-pink-600 to-rose-600"></div>
    @endif
    
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/15 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-slow"></div>
    
    <div class="relative z-10 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('usuarios.index') }}" 
                   class="w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl flex items-center justify-center text-white border border-white/30 transition-all hover:scale-110">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div class="text-white" style="color: var(--text-on-medical, #ffffff);">
                    <h1 class="text-3xl font-black mb-1" style="text-shadow: 0 2px 10px rgba(0,0,0,0.15);">
                        {{ $usuario->nombre_completo }}
                    </h1>
                    <div class="flex items-center gap-2 text-sm font-medium">
                        @if($usuario->status)
                            <span class="px-3 py-1 bg-emerald-400/90 text-white rounded-lg font-bold">Activo</span>
                        @else
                            <span class="px-3 py-1 bg-gray-400/90 text-white rounded-lg font-bold">Inactivo</span>
                        @endif
                        <span class="text-white/70">•</span>
                        <span class="text-white/90">{{ $usuario->rol->nombre_rol }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                   class="px-5 py-3 bg-amber-400/90 hover:bg-amber-500 text-white font-bold rounded-2xl shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                    <i class="bi bi-pencil"></i>
                    <span class="hidden sm:inline">Editar</span>
                </a>
                <button type="button" onclick="confirmDelete()" 
                        class="px-5 py-3 bg-red-500/90 hover:bg-red-600 text-white font-bold rounded-2xl shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                    <i class="bi bi-trash"></i>
                    <span class="hidden sm:inline">Eliminar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Información Personal -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-indigo-300 to-purple-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3 pb-3 border-b border-gray-200/50">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg">
                        <i class="bi bi-person"></i>
                    </div>
                    Información Personal
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Nombre Completo</p>
                        <p class="text-gray-900 text-lg font-bold">
                            {{ $perfil->primer_nombre }} {{ $perfil->segundo_nombre }} 
                            {{ $perfil->primer_apellido }} {{ $perfil->segundo_apellido }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Cédula</p>
                        <p class="text-gray-900 font-mono text-lg font-bold">
                            {{ $perfil->tipo_documento }}-{{ $perfil->numero_documento }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Email</p>
                        <div class="flex items-center gap-2">
                            <a href="mailto:{{ $usuario->correo }}" class="text-blue-600 hover:underline font-medium">
                                {{ $usuario->correo }}
                            </a>
                            @if($usuario->email_verified_at)
                                <i class="bi bi-patch-check-fill text-green-500" title="Verificado"></i>
                            @else
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-bold">No verificado</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Teléfono</p>
                        <p class="text-gray-900 font-mono font-medium">
                            {{ $perfil->prefijo_tlf }} {{ $perfil->numero_tlf }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Fecha de Nacimiento</p>
                        <p class="text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($perfil->fecha_nac)->format('d/m/Y') }}
                            <span class="text-sm text-gray-500 ml-1">({{ \Carbon\Carbon::parse($perfil->fecha_nac)->age }} años)</span>
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Género</p>
                        <p class="text-gray-900 capitalize font-medium">{{ $perfil->genero }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Específica del Rol -->
        @if($usuario->medico)
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3 pb-3 border-b border-gray-200/50">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    Información Profesional
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Nro. Colegiatura</p>
                        <p class="text-gray-900 font-mono font-medium">{{ $perfil->nro_colegiatura ?? 'No registrado' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Formación Académica</p>
                        <p class="text-gray-900 whitespace-pre-line font-medium">{{ $perfil->formacion_academica ?? 'No registrada' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Experiencia Profesional</p>
                        <p class="text-gray-900 whitespace-pre-line font-medium">{{ $perfil->experiencia_profesional ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($usuario->paciente)
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-300 via-cyan-300 to-blue-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3 pb-3 border-b border-gray-200/50">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center text-white shadow-lg">
                        <i class="bi bi-person-heart"></i>
                    </div>
                    Información de Paciente
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Ocupación</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->ocupacion ?? 'No registrada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Estado Civil</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->estado_civil ?? 'No registrado' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Ubicación -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-rose-300 via-pink-300 to-red-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-3 pb-3 border-b border-gray-200/50">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white shadow-lg">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    Ubicación
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Estado</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->estado->estado ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Ciudad</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->ciudad->ciudad ?? 'No especificada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Municipio</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->municipio->municipio ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Parroquia</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->parroquia->parroquia ?? 'No especificada' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Dirección Detallada</p>
                        <p class="text-gray-900 font-medium">{{ $perfil->direccion_detallada ?? 'No especificada' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Resumen -->
        <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-indigo-600 to-purple-700 text-white shadow-2xl p-6">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full filter blur-2xl"></div>
            <div class="relative flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-2xl font-black shadow-lg">
                    {{ substr($perfil->primer_nombre, 0, 1) }}{{ substr($perfil->primer_apellido, 0, 1) }}
                </div>
                <div>
                    <p class="text-white/80 text-sm font-medium">Rol actual</p>
                    <p class="font-black text-xl">{{ $usuario->rol->nombre_rol }}</p>
                </div>
            </div>
            <div class="pt-4 border-t border-white/20">
                <p class="text-white/80 text-sm font-medium mb-1">Miembro desde</p>
                <p class="font-bold text-lg">{{ $usuario->created_at->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <!-- Metadata -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-300 via-slate-300 to-zinc-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
                <h3 class="font-black text-gray-900 mb-4 text-lg">Metadatos</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">ID Usuario</span>
                        <span class="font-mono text-gray-900 font-bold">#{{ $usuario->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Actualización</span>
                        <span class="text-gray-900 text-right font-bold">{{ $usuario->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Email Verificado</span>
                        <span class="text-gray-900 font-bold">
                            @if($usuario->email_verified_at)
                                <span class="text-green-600">Sí</span>
                            @else
                                <span class="text-red-500">No</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-md transition-opacity opacity-0" id="modalBackdrop"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-[2rem] bg-white/95 backdrop-blur-xl text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 border-2 border-white" id="modalPanel">
                <div class="bg-gradient-to-br from-white/90 to-gray-50/80 px-6 pb-4 pt-5 sm:p-8 sm:pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 shadow-lg sm:mx-0 sm:h-12 sm:w-12">
                            <i class="bi bi-exclamation-triangle text-white text-2xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-xl font-black leading-6 text-gray-900">Eliminar Usuario</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 font-medium">¿Estás seguro de que deseas eliminar este usuario? Esta acción es irreversible y eliminará todos los datos asociados.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100/80 backdrop-blur-sm px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 gap-3">
                    <button type="button" id="confirmButton" 
                            class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 px-4 py-3 text-sm font-black text-white shadow-lg hover:from-red-600 hover:to-rose-700 hover:scale-105 sm:w-auto transition-all">
                        <i class="bi bi-trash"></i> Sí, eliminar
                    </button>
                    <button type="button" onclick="closeModal()" 
                            class="mt-3 inline-flex w-full justify-center items-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-black text-gray-900 shadow-md hover:bg-gray-50 hover:scale-105 sm:mt-0 sm:w-auto transition-all border-2 border-gray-200">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
const modal = document.getElementById('confirmationModal');
const backdrop = document.getElementById('modalBackdrop');
const panel = document.getElementById('modalPanel');
const confirmBtn = document.getElementById('confirmButton');
const userId = {{ $usuario->id }};

function confirmDelete() {
    modal.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
        panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
    }, 10);
}

function closeModal() {
    backdrop.classList.add('opacity-0');
    panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
    panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

confirmBtn.addEventListener('click', function() {
    confirmBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Eliminando...';
    confirmBtn.disabled = true;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('usuarios.destroy', ':id') }}".replace(':id', userId);
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    form.appendChild(methodField);
    
    document.body.appendChild(form);
    form.submit();
});

backdrop.addEventListener('click', closeModal);
</script>
@endsection
