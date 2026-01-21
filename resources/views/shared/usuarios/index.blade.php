@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $temaDinamico = $admin->tema_dinamico ?? false;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600';
    $baseColorClass = str_contains($bannerColor, 'from-') ? $bannerColor : '';
    $baseColorStyle = str_contains($bannerColor, '#') ? 'background-color: ' . $bannerColor : '';
@endphp

@section('title', 'Usuarios')

@section('content')
<!-- Hero Banner Compacto con Tema Dinámico -->
<div class="relative overflow-hidden rounded-[2rem] {{ $baseColorClass }} shadow-2xl mb-8" 
     style="{{ $baseColorStyle }}; min-height: 200px;">
     
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600"></div>
    @endif
    
    <!-- Animated Orbs -->
    <div class="absolute -top-10 -right-10 w-64 h-64 bg-white/15 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb"></div>
    <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-slow"></div>
    
    <div class="relative z-10 p-8 flex items-center justify-between">
        <div class="text-white" style="color: var(--text-on-medical, #ffffff);">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30 mb-3">
                <i class="bi bi-shield-lock text-xs"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Gestión de Usuarios</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black mb-2" style="text-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                Usuarios del Sistema
            </h1>
            <p class="text-white/90 text-sm font-medium" style="color: var(--text-on-medical, #ffffff); opacity: 0.95;">
                Administra usuarios, roles y permisos
            </p>
        </div>
        <a href="{{ route('usuarios.create') }}" 
           class="flex items-center gap-2 px-6 py-3.5 bg-white/95 backdrop-blur-md hover:bg-white hover:scale-105 border-2 border-white/50 shadow-xl rounded-2xl transition-all font-bold"
           style="color: var(--medical-500, #6366f1);">
            <i class="bi bi-plus-lg text-lg"></i>
            <span>Nuevo Usuario</span>
        </a>
    </div>
</div>

<!-- Stats Cards Premium -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-gray-900 border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                <i class="bi bi-people text-white text-2xl"></i>
            </div>
            <div class="w-2 h-2 rounded-full bg-blue-500 group-hover:animate-pulse"></div>
        </div>
        <p class="text-4xl font-black mb-1">{{ $stats['total'] ?? 0 }}</p>
        <p class="text-xs text-gray-600 uppercase tracking-widest font-bold">Total</p>
    </div>
    
    <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-gray-900 border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                <i class="bi bi-check-circle text-white text-2xl"></i>
            </div>
            <div class="w-2 h-2 rounded-full bg-emerald-400 group-hover:animate-pulse"></div>
        </div>
        <p class="text-4xl font-black mb-1">{{ $stats['activos'] ?? 0 }}</p>
        <p class="text-xs text-gray-600 uppercase tracking-widest font-bold">Activos</p>
    </div>
    
    <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-gray-900 border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                <i class="bi bi-person-badge text-white text-2xl"></i>
            </div>
            <div class="w-2 h-2 rounded-full bg-purple-400 group-hover:animate-pulse"></div>
        </div>
        <p class="text-4xl font-black mb-1">{{ $stats['medicos'] ?? 0 }}</p>
        <p class="text-xs text-gray-600 uppercase tracking-widest font-bold">Médicos</p>
    </div>
    
    <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-gray-900 border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                <i class="bi bi-person-check text-white text-2xl"></i>
            </div>
            <div class="w-2 h-2 rounded-full bg-amber-400 group-hover:animate-pulse"></div>
        </div>
        <p class="text-4xl font-black mb-1">{{ $stats['pacientes'] ?? 0 }}</p>
        <p class="text-xs text-gray-600 uppercase tracking-widest font-bold">Pacientes</p>
    </div>
</div>

<!-- Filters Card -->
<div class="relative group mb-8">
    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-purple-300 to-pink-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
    <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Buscar</label>
                <input type="text" name="search" 
                       class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                       placeholder="Nombre, email, cédula..." 
                       value="{{ request('search') }}">
            </div>
            <div>
                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Rol</label>
                <select name="rol" class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium">
                    <option value="">Todos</option>
                    <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="medico" {{ request('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                    <option value="paciente" {{ request('rol') == 'paciente' ? 'selected' : '' }}>Paciente</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Estado</label>
                <select name="status" class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium">
                    <option value="">Todos</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <div class="md:col-span-2 flex items-end gap-3">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <a href="{{ route('usuarios.index') }}" 
                   class="px-6 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 hover:border-gray-300 text-gray-700 font-bold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all">
                    <i class="bi bi-x-lg"></i> Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table Card Premium -->
<div class="relative group">
    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
    <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50/80 to-transparent border-b-2 border-gray-200/50">
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest">Usuario</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest w-32">Rol</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest w-32">Último Acceso</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest w-24">Estado</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/50">
                    @forelse($usuarios ?? [] as $usuario)
                    <tr class="hover:bg-white/70 transition-all group/row">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg group-hover/row:scale-110 transition-transform">
                                    {{ substr($usuario->nombre_completo ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-gray-900">{{ $usuario->nombre_completo }}</p>
                                    <p class="text-sm text-gray-500 font-medium">{{ $usuario->cedula }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-700 font-medium">{{ $usuario->correo ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($usuario->rol_id == 1)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-red-500 to-rose-600 text-white text-xs font-black uppercase tracking-wider rounded-lg shadow-md">
                                <i class="bi bi-shield-fill-check"></i> Admin
                            </span>
                            @elseif($usuario->rol_id == 2)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white text-xs font-black uppercase tracking-wider rounded-lg shadow-md">
                                <i class="bi bi-hospital"></i> Médico
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-black uppercase tracking-wider rounded-lg shadow-md">
                                <i class="bi bi-person-check"></i> Paciente
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600 text-sm font-medium">{{ isset($usuario->last_login) ? \Carbon\Carbon::parse($usuario->last_login)->diffForHumans() : 'Nunca' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($usuario->status)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-emerald-400 to-green-500 text-white text-xs font-black uppercase tracking-wider rounded-lg shadow-md">
                                <i class="bi bi-check-circle-fill"></i> Activo
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-gray-400 to-gray-500 text-white text-xs font-black uppercase tracking-wider rounded-lg shadow-md">
                                <i class="bi bi-x-circle-fill"></i> Inactivo
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('usuarios.show', $usuario->id) }}" 
                                   class="p-2.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl transition-all hover:scale-110 shadow-sm" 
                                   title="Ver">
                                    <i class="bi bi-eye text-sm"></i>
                                </a>
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                                   class="p-2.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-xl transition-all hover:scale-110 shadow-sm" 
                                   title="Editar">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>
                                <button onclick="toggleStatus({{ $usuario->id }})" 
                                        class="p-2.5 {{ $usuario->status ? 'bg-rose-100 hover:bg-rose-200 text-rose-700' : 'bg-emerald-100 hover:bg-emerald-200 text-emerald-700' }} rounded-xl transition-all hover:scale-110 shadow-sm" 
                                        title="{{ $usuario->status ? 'Desactivar' : 'Activar' }}">
                                    <i class="bi {{ $usuario->status ? 'bi-x-circle' : 'bi-check-circle' }} text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <i class="bi bi-inbox text-6xl text-gray-300 mb-4 block"></i>
                            <p class="text-gray-500 font-bold text-lg">No se encontraron usuarios</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($usuarios) && $usuarios->hasPages())
        <div class="p-6 border-t-2 border-gray-200/50 bg-gradient-to-r from-gray-50/50 to-transparent">
            {{ $usuarios->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Confirmation Modal Premium -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-md transition-opacity opacity-0" id="modalBackdrop"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-[2rem] bg-white/95 backdrop-blur-xl text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 border-2 border-white" id="modalPanel">
                <div class="bg-gradient-to-br from-white/90 to-gray-50/80 px-6 pb-4 pt-5 sm:p-8 sm:pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg sm:mx-0 sm:h-12 sm:w-12">
                            <i class="bi bi-exclamation-triangle text-white text-2xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-xl font-black leading-6 text-gray-900" id="modal-title">Confirmar acción</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 font-medium">¿Estás seguro de que deseas cambiar el estado de este usuario? Esta acción afectará su acceso al sistema.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100/80 backdrop-blur-sm px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 gap-3">
                    <button type="button" id="confirmButton" 
                            class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 text-sm font-black text-white shadow-lg hover:from-indigo-600 hover:to-purple-700 hover:scale-105 sm:w-auto transition-all">
                        <i class="bi bi-check-lg"></i> Confirmar cambio
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
    
    /* Custom scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.3); }
</style>
@endpush

<script>
let currentUserId = null;
const modal = document.getElementById('confirmationModal');
const backdrop = document.getElementById('modalBackdrop');
const panel = document.getElementById('modalPanel');
const confirmBtn = document.getElementById('confirmButton');

function toggleStatus(id) {
    currentUserId = id;
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
    setTimeout(() => {
        modal.classList.add('hidden');
        currentUserId = null;
    }, 300);
}

confirmBtn.addEventListener('click', function() {
    if (currentUserId) {
        confirmBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Procesando...';
        confirmBtn.disabled = true;
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('usuarios.destroy', ':id') }}".replace(':id', currentUserId);
        
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
    }
});

backdrop.addEventListener('click', closeModal);
</script>
@endsection
