@extends('layouts.admin')

@php
    $admin = auth()->user()->administrador;
    $temaDinamico = $admin->tema_dinamico ?? false;
    $bannerColor = $admin->banner_color ?? 'bg-gradient-to-r from-blue-600 to-indigo-700';
    $baseColorClass = str_contains($bannerColor, 'from-') ? $bannerColor : '';
    $baseColorStyle = str_contains($bannerColor, '#') ? 'background-color: ' . $bannerColor : '';
    
    // Calcular altura máxima para el gráfico
    $maxCitas = collect($chartData)->max('citas');
    $maxCitas = $maxCitas > 0 ? $maxCitas : 1;
@endphp

@section('title', 'Dashboard Administrativo')

@section('content')
<!-- HERO BANNER Ultra Premium -->
<div class="relative overflow-hidden rounded-[2rem] {{ $baseColorClass }} shadow-2xl mb-10" 
     style="{{ $baseColorStyle }}; min-height: 320px;">
     
    @if(!$baseColorClass && !$baseColorStyle)
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600"></div>
    @endif

    <!-- Orbs animados glassmorphic mejorados --> 
    <div class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-white/20 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-white/15 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-slow"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float-orb-delayed"></div>

    <div class="relative z-10 p-10">
        <div class="flex flex-col md:flex-row items-start justify-between gap-8 mb-8">
            <div class="text-white space-y-3" style="color: var(--text-on-medical, #ffffff);">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30 mb-2">
                    <i class="bi bi-shield-check text-sm"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">{{ $admin->tipo_admin }}</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-display font-black mb-3 leading-tight" style="text-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                    ¡Hola, {{ $admin->primer_nombre }}! 
                </h2>
                <p class="text-white/90 text-base flex items-center gap-2" style="color: var(--text-on-medical, #ffffff); opacity: 0.95;">
                    <i class="bi bi-calendar3"></i>
                    {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>
            <a href="{{ route('admin.perfil.edit') }}" 
               class="flex items-center gap-2 px-6 py-3.5 bg-white/95 backdrop-blur-md hover:bg-white text-gray-900 hover:scale-105 border-2 border-white/50 shadow-xl rounded-2xl transition-all font-bold" 
               style="color: var(--medical-500, #2563eb);">
                <i class="bi bi-palette text-lg"></i> 
                <span>Personalizar</span>
            </a>
        </div>
        
        <!-- Stats Grid Mejorado -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-white border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="bi bi-person-badge text-2xl"></i>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-white/60 group-hover:animate-pulse"></div>
                </div>
                <p class="text-4xl font-black mb-1">{{ $stats['medicos'] ?? 0 }}</p>
                <p class="text-xs text-white/90 uppercase tracking-widest font-bold">Médicos</p>
            </div>
            
            <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-white border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="bi bi-people text-2xl"></i>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-white/60 group-hover:animate-pulse"></div>
                </div>
                <p class="text-4xl font-black mb-1">{{ $stats['pacientes'] ?? 0 }}</p>
                <p class="text-xs text-white/90 uppercase tracking-widest font-bold">Pacientes</p>
            </div>
            
            <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-white border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-emerald-400 group-hover:animate-pulse"></div>
                </div>
                <p class="text-4xl font-black mb-1">{{ $stats['citas_hoy'] ?? 0 }}</p>
                <p class="text-xs text-white/90 uppercase tracking-widest font-bold">Citas Hoy</p>
            </div>
            
            <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-white border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="bi bi-currency-dollar text-2xl"></i>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-amber-400 group-hover:animate-pulse"></div>
                </div>
                <p class="text-4xl font-black mb-1">${{ number_format($stats['ingresos_mes'] ?? 0, 0) }}</p>
                <p class="text-xs text-white/90 uppercase tracking-widest font-bold">Ingresos</p>
            </div>
            
            <div class="group bg-white/15 backdrop-blur-lg rounded-2xl p-5 text-white border border-white/30 hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="bi bi-person-check text-2xl"></i>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-white/60 group-hover:animate-pulse"></div>
                </div>
                <p class="text-4xl font-black mb-1">{{ $stats['usuarios_activos'] ?? 0 }}</p>
                <p class="text-xs text-white/90 uppercase tracking-widest font-bold">Activos</p>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left: Charts & Activity (2/3) -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Chart Card Ultra Premium -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-8 hover:shadow-blue-200/50 transition-all duration-300">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-xl">
                            <i class="bi bi-graph-up-arrow text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Actividad Semanal</h3>
                            <p class="text-sm text-gray-600 font-medium">Últimos 7 días</p>
                        </div>
                    </div>
                </div>
                
                <!-- Dynamic Chart -->
                <div class="h-80 flex items-end justify-between gap-4 px-2">
                    @foreach($chartData as $data)
                        @php
                            $heightPercent = $maxCitas > 0 ? ($data['citas'] / $maxCitas) * 100 : 0;
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-gradient-to-t from-blue-500 via-indigo-500 to-purple-500 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-600 rounded-2xl relative group/bar transition-all cursor-pointer shadow-xl hover:shadow-2xl" 
                                 style="height: {{ max($heightPercent, 5) }}%">
                                <div class="absolute -top-14 left-1/2 transform -translate-x-1/2 bg-gray-900/95 backdrop-blur-sm text-white text-sm font-black py-2 px-4 rounded-2xl opacity-0 group-hover/bar:opacity-100 transition-all whitespace-nowrap shadow-2xl z-20 border border-white/20">
                                    <div class="text-center">
                                        <div class="text-2xl mb-1">{{ $data['citas'] }}</div>
                                        <div class="text-xs opacity-80">citas</div>
                                    </div>
                                </div>
                                <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 text-white text-sm font-black opacity-0 group-hover/bar:opacity-100 transition-opacity">
                                    {{ $data['citas'] }}
                                </div>
                            </div>
                            <span class="text-sm font-black text-gray-700 uppercase tracking-wide">{{ $data['dia'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Activity Feed Ultra Premium -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl overflow-hidden hover:shadow-emerald-200/50 transition-all duration-300">
                <div class="p-8 border-b border-gray-200/50 bg-gradient-to-r from-gray-50/80 to-transparent">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600 flex items-center justify-center text-white shadow-xl">
                            <i class="bi bi-activity text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Actividad Reciente</h3>
                            <p class="text-sm text-gray-600 font-medium">Últimas actualizaciones</p>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-100/50 max-h-[450px] overflow-y-auto">
                    @forelse($actividadReciente ?? [] as $actividad)
                    <div class="p-5 hover:bg-white/70 transition-all flex gap-4 group/item">
                        <div class="w-14 h-14 rounded-2xl {{ $actividad->tipo_clase ?? 'bg-blue-100' }} flex items-center justify-center flex-shrink-0 group-hover/item:scale-110 transition-transform shadow-md border-2 border-white">
                            <i class="bi {{ $actividad->icono ?? 'bi-check' }} {{ $actividad->icono_clase ?? 'text-blue-600' }} text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900 font-bold mb-1">{{ $actividad->descripcion ?? 'Actividad' }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium">
                                <i class="bi bi-clock"></i>
                                {{ isset($actividad->created_at) ? \Carbon\Carbon::parse($actividad->created_at)->diffForHumans() : 'Hace unos momentos' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-400">
                        <i class="bi bi-inbox text-6xl mb-4 block"></i>
                        <p class="text-sm font-bold">No hay actividad reciente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Actions & Tasks (1/3) -->
    <div class="space-y-8">
        
        <!-- Tasks Card Ultra Premium -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-400 via-orange-400 to-rose-400 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-8 hover:shadow-amber-200/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 via-orange-600 to-red-600 flex items-center justify-center text-white shadow-xl">
                        <i class="bi bi-list-check text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Pendientes</h3>
                        <p class="text-xs text-gray-600 font-medium">Requieren atención</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="group/task p-5 bg-gradient-to-br from-amber-50/90 to-orange-50/70 hover:from-amber-100/90 hover:to-orange-100/70 backdrop-blur-sm rounded-2xl border-2 border-amber-200/80 shadow-md hover:shadow-xl transition-all cursor-pointer">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/task:scale-110 transition-transform">
                                    <i class="bi bi-calendar-x text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-black text-gray-900 text-2xl">{{ $tareas['citas_sin_confirmar'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-700 font-bold">Sin confirmar</p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-amber-600 text-xl opacity-0 group-hover/task:opacity-100 transition-opacity"></i>
                        </div>
                    </div>
                    
                    <div class="group/task p-5 bg-gradient-to-br from-rose-50/90 to-pink-50/70 hover:from-rose-100/90 hover:to-pink-100/70 backdrop-blur-sm rounded-2xl border-2 border-rose-200/80 shadow-md hover:shadow-xl transition-all cursor-pointer">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-rose-500 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/task:scale-110 transition-transform">
                                    <i class="bi bi-cash-coin text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-black text-gray-900 text-2xl">{{ $tareas['pagos_pendientes'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-700 font-bold">Pagos pendientes</p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-rose-600 text-xl opacity-0 group-hover/task:opacity-100 transition-opacity"></i>
                        </div>
                    </div>
                    
                    <div class="group/task p-5 bg-gradient-to-br from-blue-50/90 to-cyan-50/70 hover:from-blue-100/90 hover:to-cyan-100/70 backdrop-blur-sm rounded-2xl border-2 border-blue-200/80 shadow-md hover:shadow-xl transition-all cursor-pointer">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/task:scale-110 transition-transform">
                                    <i class="bi bi-clipboard-data text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-black text-gray-900 text-2xl">{{ $tareas['resultados_pendientes'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-700 font-bold">Laboratorios</p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-blue-600 text-xl opacity-0 group-hover/task:opacity-100 transition-opacity"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Ultra Premium -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-400 via-indigo-400 to-blue-400 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-8 hover:shadow-purple-200/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 via-indigo-600 to-blue-600 flex items-center justify-center text-white shadow-xl">
                        <i class="bi bi-lightning-charge text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Acciones</h3>
                        <p class="text-xs text-gray-600 font-medium">Accesos rápidos</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('citas.create') }}" 
                       class="group/action flex items-center gap-4 px-5 py-4 rounded-2xl border-2 border-blue-200 bg-gradient-to-r from-blue-50/70 to-indigo-50/50 hover:from-blue-100/90 hover:to-indigo-100/70 hover:border-blue-400 hover:shadow-xl hover:scale-105 transition-all font-bold text-gray-800">
                        <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/action:scale-110 transition-transform">
                            <i class="bi bi-calendar-plus text-lg"></i>
                        </div>
                        <span class="flex-1">Nueva Cita</span>
                        <i class="bi bi-arrow-right text-blue-600 opacity-0 group-hover/action:opacity-100 transition-opacity"></i>
                    </a>
                    
                    <a href="{{ route('medicos.index') }}" 
                       class="group/action flex items-center gap-4 px-5 py-4 rounded-2xl border-2 border-emerald-200 bg-gradient-to-r from-emerald-50/70 to-teal-50/50 hover:from-emerald-100/90 hover:to-teal-100/70 hover:border-emerald-400 hover:shadow-xl hover:scale-105 transition-all font-bold text-gray-800">
                        <div class="w-11 h-11 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/action:scale-110 transition-transform">
                            <i class="bi bi-person-badge text-lg"></i>
                        </div>
                        <span class="flex-1">Ver Médicos</span>
                        <i class="bi bi-arrow-right text-emerald-600 opacity-0 group-hover/action:opacity-100 transition-opacity"></i>
                    </a>
                    
                    <a href="{{ route('pacientes.index') }}" 
                       class="group/action flex items-center gap-4 px-5 py-4 rounded-2xl border-2 border-purple-200 bg-gradient-to-r from-purple-50/70 to-pink-50/50 hover:from-purple-100/90 hover:to-pink-100/70 hover:border-purple-400 hover:shadow-xl hover:scale-105 transition-all font-bold text-gray-800">
                        <div class="w-11 h-11 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/action:scale-110 transition-transform">
                            <i class="bi bi-people text-lg"></i>
                        </div>
                        <span class="flex-1">Ver Pacientes</span>
                        <i class="bi bi-arrow-right text-purple-600 opacity-0 group-hover/action:opacity-100 transition-opacity"></i>
                    </a>
                    
                    <a href="{{ route('pagos.index') }}" 
                       class="group/action flex items-center gap-4 px-5 py-4 rounded-2xl border-2 border-amber-200 bg-gradient-to-r from-amber-50/70 to-orange-50/50 hover:from-amber-100/90 hover:to-orange-100/70 hover:border-amber-400 hover:shadow-xl hover:scale-105 transition-all font-bold text-gray-800">
                        <div class="w-11 h-11 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover/action:scale-110 transition-transform">
                            <i class="bi bi-cash-stack text-lg"></i>
                        </div>
                        <span class="flex-1">Gestionar Pagos</span>
                        <i class="bi bi-arrow-right text-amber-600 opacity-0 group-hover/action:opacity-100 transition-opacity"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Links Grid Ultra Premium -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-300 via-gray-400 to-gray-500 rounded-[2rem] opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-500"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/80 shadow-2xl p-8 hover:shadow-gray-200/50 transition-all duration-300">
                <h4 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-6">Enlaces Rápidos</h4>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('especialidades.index') }}" 
                       class="group/link p-5 text-center bg-gradient-to-br from-white/80 to-gray-50/60 hover:from-blue-50/90 hover:to-indigo-50/70 rounded-2xl border-2 border-gray-200 hover:border-blue-400 transition-all hover:shadow-xl hover:scale-105">
                        <i class="bi bi-bookmark text-4xl text-gray-400 group-hover/link:text-blue-600 mb-3 block group-hover/link:scale-125 transition-transform"></i>
                        <span class="text-[11px] font-black text-gray-700 group-hover/link:text-blue-700 uppercase block">Especialidades</span>
                    </a>
                    <a href="{{ route('consultorios.index') }}" 
                       class="group/link p-5 text-center bg-gradient-to-br from-white/80 to-gray-50/60 hover:from-emerald-50/90 hover:to-teal-50/70 rounded-2xl border-2 border-gray-200 hover:border-emerald-400 transition-all hover:shadow-xl hover:scale-105">
                        <i class="bi bi-building text-4xl text-gray-400 group-hover/link:text-emerald-600 mb-3 block group-hover/link:scale-125 transition-transform"></i>
                        <span class="text-[11px] font-black text-gray-700 group-hover/link:text-emerald-700 uppercase block">Sedes</span>
                    </a>
                    <a href="{{ route('configuracion.index') }}" 
                       class="group/link p-5 text-center bg-gradient-to-br from-white/80 to-gray-50/60 hover:from-purple-50/90 hover:to-indigo-50/70 rounded-2xl border-2 border-gray-200 hover:border-purple-400 transition-all hover:shadow-xl hover:scale-105">
                        <i class="bi bi-gear text-4xl text-gray-400 group-hover/link:text-purple-600 mb-3 block group-hover/link:scale-125 transition-transform"></i>
                        <span class="text-[11px] font-black text-gray-700 group-hover/link:text-purple-700 uppercase block">Configuración</span>
                    </a>
                    <a href="{{ route('facturacion.index') }}" 
                       class="group/link p-5 text-center bg-gradient-to-br from-white/80 to-gray-50/60 hover:from-amber-50/90 hover:to-orange-50/70 rounded-2xl border-2 border-gray-200 hover:border-amber-400 transition-all hover:shadow-xl hover:scale-105">
                        <i class="bi bi-file-earmark-bar-graph text-4xl text-gray-400 group-hover/link:text-amber-600 mb-3 block group-hover/link:scale-125 transition-transform"></i>
                        <span class="text-[11px] font-black text-gray-700 group-hover/link:text-amber-700 uppercase block">Reportes</span>
                    </a>
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
    .animate-float-orb-delayed { animation: float-orb 25s ease-in-out infinite; animation-delay: -8s; }
    
    /* Smooth scroll */
    * { scroll-behavior: smooth; }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.3); }
</style>
@endpush
@endsection
