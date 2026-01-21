@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-br from-red-500 via-rose-600 to-pink-600';
    $baseColorClass = str_contains($bannerColor, 'from-') ? $bannerColor : '';
    $baseColorStyle = str_contains($bannerColor, '#') ? 'background-color: ' . $bannerColor : '';
@endphp

@section('title', 'Administradores')

@section('content')
<!-- Hero Banner con Tema Dinámico -->
<div class="relative overflow-hidden rounded-[2rem] {{ $baseColorClass }} shadow-2xl mb-8" 
     style="{{ $baseColorStyle }}; min-height: 180px;">
     
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-br from-red-500 via-rose-600 to-pink-600"></div>
    @endif
    
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/15 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-slow"></div>
    
    <div class="relative z-10 p-6 flex items-center justify-between">
        <div class="text-white" style="color: var(--text-on-medical, #ffffff);">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30 mb-3">
                <i class="bi bi-shield-shaded text-xs"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Gestión Administrativa</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black mb-2" style="text-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                Administradores del Sistema
            </h1>
            <p class="text-white/90 text-sm font-medium" style="opacity: 0.95;">
                Gestiona los derechos de acceso y usuarios administrativos
            </p>
        </div>
        <a href="{{ route('administradores.create') }}" 
           class="flex items-center gap-2 px-6 py-3.5 bg-white/95 backdrop-blur-md hover:bg-white hover:scale-105 border-2 border-white/50 shadow-xl rounded-2xl transition-all font-bold"
           style="color: var(--medical-500, #6366f1);">
            <i class="bi bi-person-plus-fill text-lg"></i>
            <span>Nuevo Administrador</span>
        </a>
    </div>
</div>

<!-- Filtros Premium -->
<div class="relative group mb-6">
    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-300 via-indigo-300 to-purple-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
    <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-6">
        <form method="GET" action="{{ route('administradores.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Búsqueda Global</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="buscar" 
                           placeholder="Nombre, documento, correo..." 
                           class="w-full pl-10 px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium" 
                           value="{{ request('buscar') }}">
                </div>
            </div>
            <div>
                <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Estado</label>
                <select name="status" 
                        class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 rounded-xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all font-medium cursor-pointer" 
                        onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex-1 px-5 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-black rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    @if(request()->hasAny(['buscar', 'status']))
                    <a href="{{ route('administradores.index') }}" 
                       class="px-4 py-3 bg-white/70 backdrop-blur-sm border-2 border-gray-200/60 hover:border-gray-300 text-gray-700 font-bold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center" 
                       title="Limpiar Filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabla Premium -->
<div class="relative group">
    <div class="absolute -inset-0.5 bg-gradient-to-r from-red-300 via-rose-300 to-pink-300 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
    <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50/80 to-transparent border-b-2 border-gray-200/50">
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest">Perfil</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest">Identificación</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest">Rol / Consultorios</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-700 uppercase tracking-widest">Estado</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-widest">Registro</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-widest">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/50">
                @forelse($administradores ?? [] as $admin)
                <tr class="hover:bg-white/70 transition-all group/row {{ !$admin->status ? 'opacity-60' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                @if($admin->status)
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center text-white font-black shadow-lg text-lg">
                                        {{ strtoupper(substr($admin->primer_nombre, 0, 1)) }}{{ strtoupper(substr($admin->primer_apellido, 0, 1)) }}
                                    </div>
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                                @else
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-black shadow-lg text-lg">
                                        {{ strtoupper(substr($admin->primer_nombre, 0, 1)) }}{{ strtoupper(substr($admin->primer_apellido, 0, 1)) }}
                                    </div>
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-gray-500 border-2 border-white rounded-full"></span>
                                @endif
                            </div>
                            <div>
                                <div class="font-black text-gray-900">
                                    {{ $admin->primer_nombre }} {{ $admin->primer_apellido }}
                                </div>
                                <div class="text-xs text-gray-500 flex items-center gap-1 font-medium">
                                    <i class="bi bi-envelope"></i> {{ $admin->usuario->correo }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div class="font-bold text-gray-900">{{ $admin->tipo_documento }}-{{ $admin->numero_documento }}</div>
                            <div class="text-xs text-gray-500 mt-0.5 font-medium">
                                <i class="bi bi-telephone text-gray-400 mr-1"></i>
                                {{ $admin->prefijo_tlf }} {{ $admin->numero_tlf }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1.5">
                            @if($admin->tipo_admin == 'Root')
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md w-fit">
                                    <i class="bi bi-star-fill mr-1.5"></i> ROOT
                                </span>
                                <span class="text-xs text-gray-400 italic font-medium">Acceso Total</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md w-fit">
                                    <i class="bi bi-person-badge mr-1.5"></i> ADMIN
                                </span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @forelse($admin->consultorios as $c)
                                        <span class="px-2 py-0.5 bg-gray-100/80 backdrop-blur-sm text-gray-600 rounded-lg text-[10px] border border-gray-200 font-bold" title="{{ $c->nombre }}">
                                            {{ Str::limit($c->nombre, 15) }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-amber-500 font-bold italic">Sin consultorios</span>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($admin->status)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-gradient-to-r from-emerald-400 to-green-500 text-white shadow-lg">
                                <span class="w-2 h-2 bg-white rounded-full mr-1.5 animate-pulse"></span>
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-md">
                                <span class="w-2 h-2 bg-white rounded-full mr-1.5"></span>
                                Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-900">{{ $admin->created_at->format('d M, Y') }}</span>
                            <span class="text-xs font-medium">{{ $admin->created_at->diffForHumans() }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2 justify-end opacity-0 group-hover/row:opacity-100 transition-opacity">
                            <a href="{{ route('administradores.show', $admin->id) }}" 
                               class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow-md hover:scale-110 transition-all" 
                               title="Ver Detalles">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('administradores.edit', $admin->id) }}" 
                               class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-md hover:scale-110 transition-all" 
                               title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button onclick="toggleStatus({{ $admin->id }}, {{ $admin->status }})" 
                                    class="px-3 py-2 {{ $admin->status ? 'bg-red-500 hover:bg-red-600' : 'bg-emerald-500 hover:bg-emerald-600' }} text-white font-bold rounded-xl shadow-md hover:scale-110 transition-all" 
                                    title="{{ $admin->status ? 'Desactivar' : 'Activar' }}">
                                <i class="bi {{ $admin->status ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center bg-gradient-to-br from-gray-50/50 to-transparent">
                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mb-4 shadow-lg">
                                <i class="bi bi-search text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 mb-2">No se encontraron resultados</h3>
                            <p class="text-gray-500 text-sm mb-5 font-medium">No hay administradores que coincidan con los criterios de búsqueda.</p>
                            @if(request()->hasAny(['buscar', 'status']))
                                <a href="{{ route('administradores.index') }}" 
                                   class="px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-black rounded-xl shadow-lg hover:scale-105 transition-all">
                                    Limpiar Filtros
                                </a>
                            @else
                                <a href="{{ route('administradores.create') }}" 
                                   class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-black rounded-xl shadow-lg hover:scale-105 transition-all">
                                    Crear primer administrador
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($administradores) && $administradores->hasPages())
    <div class="bg-white/50 backdrop-blur-sm px-6 py-4 border-t border-gray-200/50 rounded-b-[2rem]">
        {{ $administradores->links() }}
    </div>
    @endif
</div>

<!-- Premium Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-md transition-opacity opacity-0" id="modalBackdrop"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-[2rem] bg-white/95 backdrop-blur-xl text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 border-2 border-white" id="modalPanel">
                <div class="bg-gradient-to-br from-white/90 to-gray-50/80 px-6 pb-4 pt-5 sm:p-8 sm:pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl shadow-lg sm:mx-0 sm:h-12 sm:w-12" id="modalIconBg">
                            <i class="text-white text-2xl" id="modalIcon"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-xl font-black leading-6 text-gray-900" id="modal-title">Confirmar acción</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 font-medium" id="modal-message">¿Estás seguro de continuar con esta acción?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100/80 backdrop-blur-sm px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 gap-3">
                    <button type="button" id="confirmButton" 
                            class="inline-flex w-full justify-center items-center gap-2 rounded-xl px-4 py-3 text-sm font-black text-white shadow-lg hover:scale-105 sm:w-auto transition-all">
                        Confirmar
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
let currentId = null;
const modal = document.getElementById('confirmationModal');
const backdrop = document.getElementById('modalBackdrop');
const panel = document.getElementById('modalPanel');
const confirmBtn = document.getElementById('confirmButton');
const titleElem = document.getElementById('modal-title');
const msgElem = document.getElementById('modal-message');
const iconElem = document.getElementById('modalIcon');
const iconBgElem = document.getElementById('modalIconBg');

function toggleStatus(id, currentStatus) {
    currentId = id;
    
    if (currentStatus) {
        titleElem.innerText = 'Desactivar Administrador';
        msgElem.innerText = '¿Deseas desactivar este administrador? Perderá el acceso al sistema.';
        confirmBtn.className = 'inline-flex w-full justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 px-4 py-3 text-sm font-black text-white shadow-lg hover:scale-105 sm:w-auto transition-all';
        confirmBtn.innerHTML = '<i class="bi bi-person-x-fill"></i> Sí, desactivar';
        iconBgElem.className = 'mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 shadow-lg sm:mx-0 sm:h-12 sm:w-12';
        iconElem.className = 'bi bi-person-x-fill text-white text-2xl';
    } else {
        titleElem.innerText = 'Activar Administrador';
        msgElem.innerText = '¿Deseas reactivar este administrador? Recobrará el acceso al sistema.';
        confirmBtn.className = 'inline-flex w-full justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 px-4 py-3 text-sm font-black text-white shadow-lg hover:scale-105 sm:w-auto transition-all';
        confirmBtn.innerHTML = '<i class="bi bi-person-check-fill"></i> Sí, activar';
        iconBgElem.className = 'mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 shadow-lg sm:mx-0 sm:h-12 sm:w-12';
        iconElem.className = 'bi bi-person-check-fill text-white text-2xl';
    }

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
        currentId = null;
    }, 300);
}

confirmBtn.addEventListener('click', function() {
    if (currentId) {
        confirmBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Procesando...';
        confirmBtn.disabled = true;
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('administradores.toggle-status', ':id') }}".replace(':id', currentId);
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
});

backdrop.addEventListener('click', closeModal);
</script>
@endsection
