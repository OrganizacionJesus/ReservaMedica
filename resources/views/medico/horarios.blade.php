@extends('layouts.medico')

@section('title', 'Horarios del Médico')

@section('content')
<script>
    // ============================================================
    // NUEVA ARQUITECTURA: AJAX + Alpine.js Reactivo
    // ============================================================
    
    // 2. Component Logic Factory - CON AJAX DINÁMICO
    window.makeScheduleCard = function(data) {
        return {
            editing: false,
            
            // ==========================================
            // DATOS DE TURNO MAÑANA
            // ==========================================
            manana: {
                active: !!data.manana.active,
                especialidad_id: data.manana.especialidad_id ? String(data.manana.especialidad_id) : '',
                consultorio_id: data.manana.consultorio_id ? String(data.manana.consultorio_id) : '',
                inicio: data.manana.inicio || '08:00',
                fin: data.manana.fin || '12:00',
            },
            // Lista dinámica de consultorios (ya no se usa array interno, se lee del DOM)
            // mananaConsultorios: [], 
            // tardeConsultorios: [],

            // Horario del consultorio seleccionado (mañana)
            mananaHorarioConsultorio: { inicio: '--:--', fin: '--:--' },
            // Horario del consultorio seleccionado (tarde)
            tardeHorarioConsultorio: { inicio: '--:--', fin: '--:--' },

            // Computed Helpers para compatibilidad
            get manana_active() { return this.manana.active; },
            set manana_active(val) { this.manana.active = val; },
            get tarde_active() { return this.tarde.active; },
            set tarde_active(val) { this.tarde.active = val; },
            get active() { return this.manana.active || this.tarde.active; },

            // ==========================================
            // LOGICA DOM ACTUALIZADA (Lee atributos del Option)
            // ==========================================
            
            // Ya no necesitamos cargarConsultoriosDOM interno porque lo hace el script nativo global
            
            // wrappers para change (si se necesitan)
            onEspecialidadChange(turno) {
                // El script nativo maneja la carga. Alpine solo necesita saber que cambió para resetear su modelo si es necesario.
                // Resetear consultorio y horario
                this[turno].consultorio_id = '';
                if(turno === 'manana') this.mananaHorarioConsultorio = { inicio: '--:--', fin: '--:--' };
                else this.tardeHorarioConsultorio = { inicio: '--:--', fin: '--:--' };
            },


            // ==========================================
            // ACTUALIZAR HORARIO DEL CONSULTORIO SELECCIONADO
            // ==========================================
            // ==========================================
            // ACTUALIZAR HORARIO DEL CONSULTORIO SELECCIONADO
            // ==========================================
            actualizarHorario(turno) {
                // Obtenemos el ID seleccionado
                const consultorioId = this[turno].consultorio_id;
                console.log(`[actualizarHorario] Turno: ${turno}, Consultorio ID: ${consultorioId}`);
                
                // Buscamos el elemento select en el DOM usando x-ref
                const selectEl = this.$refs[turno + 'ConsultoriosSelect'];
                if (!selectEl) return;
                
                // Buscamos la opción seleccionada
                const selectedOption = selectEl.options[selectEl.selectedIndex];
                
                if (!selectedOption || !consultorioId) {
                    console.log(`[actualizarHorario] Sin selección válida, reseteando.`);
                    if (turno === 'manana') this.mananaHorarioConsultorio = { inicio: '--:--', fin: '--:--' };
                    else this.tardeHorarioConsultorio = { inicio: '--:--', fin: '--:--' };
                    return;
                }
                
                // Leemos los data attributes que inyectó el script nativo
                const inicio = selectedOption.getAttribute('data-inicio') || '--:--';
                const fin = selectedOption.getAttribute('data-fin') || '--:--';
                
                console.log(`[actualizarHorario] Datos leídos del DOM: ${inicio} - ${fin}`);
                
                if (turno === 'manana') {
                    this.mananaHorarioConsultorio = { inicio, fin };
                } else {
                    this.tardeHorarioConsultorio = { inicio, fin };
                }
            },

            // ==========================================
            // HELPERS PARA VALIDACIÓN (mantener compatibilidad)
            // ==========================================
            getStatusClass(turno, tipo) {
                const horario = turno === 'manana' ? this.mananaHorarioConsultorio : this.tardeHorarioConsultorio;
                if (horario.inicio === '--:--') return 'text-gray-500';

                const horaUsuario = this[turno][tipo];
                
                if (tipo === 'inicio' && horaUsuario < horario.inicio) {
                    return 'text-red-600 font-bold';
                }
                if (tipo === 'fin' && horaUsuario > horario.fin) {
                    return 'text-red-600 font-bold';
                }

                return 'text-green-600 font-medium';
            },

            getInputLimits(turno) {
                const horario = turno === 'manana' ? this.mananaHorarioConsultorio : this.tardeHorarioConsultorio;
                
                let limits = { min: '00:00', max: '23:59' };
                
                if (horario.inicio !== '--:--') {
                    if (turno === 'manana') {
                        limits.min = horario.inicio;
                        limits.max = '12:00';
                    } else {
                        limits.min = '12:00';
                        limits.max = horario.fin;
                    }
                } else {
                    if (turno === 'manana') limits.max = '12:00';
                    if (turno === 'tarde') limits.min = '12:00';
                }
                return limits;
            }
        };
    };
</script>

<div class="mb-6">
    <a href="{{ route('medicos.show', $medico->id) }}" class="text-medical-600 hover:text-medical-700 inline-flex items-center text-sm font-medium mb-3">
        <i class="bi bi-arrow-left mr-1"></i> Volver al Perfil
    </a>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-display font-bold text-gray-900">Horarios de Atención</h2>
            <p class="text-gray-500 mt-1">
                Dr. {{ $medico->primer_nombre }} {{ $medico->primer_apellido }} 
                @if($medico->especialidades->count() > 0)
                    - {{ $medico->especialidades->pluck('nombre')->implode(', ') }}
                @endif
            </p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('horariosForm').submit()">
            <i class="bi bi-save mr-2"></i>
            Guardar Cambios
        </button>
    </div>
</div>

<form id="horariosForm" method="POST" action="{{ route('medicos.guardar-horario', $medico->id) }}">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- HERRAMIENTA DE DIAGNÓSTICO GLOBAL -->


<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ [Diagnostico Nativo] DOM Cargado. Inicializando eventos.');
        
        const btn = document.getElementById('btn_probar_fetch');
        const selectEsp = document.getElementById('diag_especialidad');
        const preResult = document.getElementById('diag_resultado');
        const preJson = document.getElementById('diag_json');
        const selectDestino = document.getElementById('diag_select_consultorios');
        
        if(btn) {
            btn.addEventListener('click', async function() {
                const espId = selectEsp.value;
                console.log('🚀 [Diagnostico Nativo] Click. ID:', espId);
                
                if (!espId) {
                    alert('Seleccione una especialidad primero');
                    return;
                }
                
                preResult.textContent = 'Cargando...';
                preJson.textContent = '...';
                
                // Limpiar select
                selectDestino.innerHTML = '<option>Cargando...</option>';
                
                try {
                    const url = '/ajax/citas/consultorios-por-especialidad/' + espId;
                    console.log('📡 [Diagnostico Nativo] Fetching:', url);
                    
                    const res = await fetch(url);
                    preResult.textContent = `Status: ${res.status} ${res.statusText}`;
                    
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    
                    const data = await res.json();
                    console.log('📦 [Diagnostico Nativo] Data:', data);
                    
                    preJson.textContent = JSON.stringify(data, null, 2);
                    preResult.textContent += `\nRegistros recibidos: ${data.length}`;
                    
                    // Llenar select
                    selectDestino.innerHTML = '';
                    if (data.length === 0) {
                        const opt = document.createElement('option');
                        opt.text = 'Lista vacía (0 consultorios)';
                        selectDestino.add(opt);
                        alert('Petición exitosa pero lista VACÍA.');
                    } else {
                        const optDefault = document.createElement('option');
                        optDefault.text = `Se cargaron ${data.length} consultorios`;
                        selectDestino.add(optDefault);
                        
                        data.forEach(c => {
                            const opt = document.createElement('option');
                            opt.value = c.id;
                            const h_inicio = c.horario_inicio ? c.horario_inicio.substring(0,5) : '--:--';
                            const h_fin = c.horario_fin ? c.horario_fin.substring(0,5) : '--:--';
                            opt.text = `${c.nombre} (${h_inicio} - ${h_fin})`;
                            selectDestino.add(opt);
                        });
                        alert(`¡Éxito! ${data.length} consultorios cargados en el select de prueba.`);
                    }
                    
                } catch (e) {
                    console.error('❌ [Diagnostico Nativo] Error:', e);
                    preResult.textContent += '\nError: ' + e.message;
                    alert('Error JS: ' + e.message);
                }
            });
        } else {
            console.error('❌ [Diagnostico Nativo] No se encontró el botón de prueba.');
        }
    });
</script>
        
        <!-- Configuración de Horarios -->
        <div class="lg:col-span-2 space-y-4">
            
            @php
                $diasSemana = [
                    'lunes' => 'Lunes', 
                    'martes' => 'Martes', 
                    'miercoles' => 'Miércoles', 
                    'jueves' => 'Jueves', 
                    'viernes' => 'Viernes', 
                    'sabado' => 'Sábado', 
                    'domingo' => 'Domingo'
                ];
            @endphp

            @foreach($diasSemana as $key => $diaLabel)
                @php
                    $dayRecords = $horarios->filter(function($h) use ($key, $diaLabel) {
                        return stripos($h->dia_semana, $key) !== false 
                            || stripos($h->dia_semana, $diaLabel) !== false;
                    });
                    
                    $hManana = $dayRecords->first(function($h) { return stripos($h->turno, 'm') === 0; });
                    $hTarde = $dayRecords->first(function($h) { return stripos($h->turno, 't') === 0; });

                    $isActive = $hManana || $hTarde; 
                    
                    $initData = [
                        'manana' => [
                            'active' => (bool)$hManana,
                            'consultorio_id' => $hManana ? $hManana->consultorio_id : null,
                            'especialidad_id' => $hManana ? $hManana->especialidad_id : null,
                            'inicio' => $hManana ? \Carbon\Carbon::parse($hManana->horario_inicio)->format('H:i') : null,
                            'fin' => $hManana ? \Carbon\Carbon::parse($hManana->horario_fin)->format('H:i') : null,
                        ],
                        'tarde' => [
                            'active' => (bool)$hTarde,
                            'consultorio_id' => $hTarde ? $hTarde->consultorio_id : null,
                            'especialidad_id' => $hTarde ? $hTarde->especialidad_id : null,
                            'inicio' => $hTarde ? \Carbon\Carbon::parse($hTarde->horario_inicio)->format('H:i') : null,
                            'fin' => $hTarde ? \Carbon\Carbon::parse($hTarde->horario_fin)->format('H:i') : null,
                        ]
                    ];
                @endphp
                
                <div class="card p-0 overflow-hidden hover:shadow-lg transition-shadow border border-gray-100 mb-4" 
                     x-data="makeScheduleCard(@json($initData))">
                     
                    <!-- Hidden Input for Active State (Calculated) -->
                    <input type="hidden" name="horarios[{{ $key }}][activo]" 
                           value="{{ $isActive ? 1 : 0 }}" 
                           x-bind:value="active ? 1 : 0">
                           
                    <!-- Hidden Map for Shifts (Guarantees submission even if toggle is unchecked/UI hidden) -->
                    <input type="hidden" name="horarios[{{ $key }}][manana_activa]" 
                           value="{{ $hManana ? 1 : 0 }}" 
                           x-bind:value="manana_active ? 1 : 0">
                           
                    <input type="hidden" name="horarios[{{ $key }}][tarde_activa]" 
                           value="{{ $hTarde ? 1 : 0 }}" 
                           x-bind:value="tarde_active ? 1 : 0">
                    
                    <!-- Datos de Turno Mañana (siempre se envían para preservar valores existentes) -->
                    @if($hManana)
                    <input type="hidden" name="horarios[{{ $key }}][manana_consultorio_id]" value="{{ $hManana->consultorio_id }}" x-bind:value="manana.consultorio_id">
                    <input type="hidden" name="horarios[{{ $key }}][manana_especialidad_id]" value="{{ $hManana->especialidad_id }}" x-bind:value="manana.especialidad_id">
                    <input type="hidden" name="horarios[{{ $key }}][manana_inicio]" value="{{ \Carbon\Carbon::parse($hManana->horario_inicio)->format('H:i') }}">
                    <input type="hidden" name="horarios[{{ $key }}][manana_fin]" value="{{ \Carbon\Carbon::parse($hManana->horario_fin)->format('H:i') }}">
                    @endif
                    
                    <!-- Datos de Turno Tarde (siempre se envían para preservar valores existentes) -->
                    @if($hTarde)
                    <input type="hidden" name="horarios[{{ $key }}][tarde_consultorio_id]" value="{{ $hTarde->consultorio_id }}" x-bind:value="tarde.consultorio_id">
                    <input type="hidden" name="horarios[{{ $key }}][tarde_especialidad_id]" value="{{ $hTarde->especialidad_id }}" x-bind:value="tarde.especialidad_id">
                    <input type="hidden" name="horarios[{{ $key }}][tarde_inicio]" value="{{ \Carbon\Carbon::parse($hTarde->horario_inicio)->format('H:i') }}">
                    <input type="hidden" name="horarios[{{ $key }}][tarde_fin]" value="{{ \Carbon\Carbon::parse($hTarde->horario_fin)->format('H:i') }}">
                    @endif

                    <!-- HEADER -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white shadow-sm"
                                 :class="active ? 'bg-medical-500' : 'bg-gray-300'">
                                {{ strtoupper(substr($diaLabel, 0, 1)) }}
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $diaLabel }}</h3>
                        </div>
                        
                        <!-- Actions -->
                        <div>
                            <template x-if="!editing">
                                <button type="button" @click="editing = true" class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg font-medium flex items-center transition-colors shadow-sm">
                                    <i class="bi bi-pencil-square mr-1"></i> Editar
                                </button>
                            </template>
                            
                            <template x-if="editing">
                                <button type="button" @click="editing = false" class="text-sm bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg font-medium flex items-center transition-colors shadow-sm">
                                    <i class="bi bi-check2-circle mr-1"></i> Listo
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- CONTENT BODY -->
                    <div class="p-6">
                        
                        <!-- STATE 1: SUMMARY (Saved & Not Editing) -->
                        <div x-show="!editing && active" class="space-y-4">
                            @if($hManana)
                                <div class="flex items-start gap-3 p-3 rounded-lg bg-blue-50/50 border border-blue-100">
                                    <div class="bg-blue-100 text-blue-600 p-2 rounded-md">
                                        <i class="bi bi-sun-fill"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-blue-900">Mañana ({{ \Carbon\Carbon::parse($hManana->horario_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($hManana->horario_fin)->format('H:i') }})</p>
                                        <p class="text-xs text-blue-700 mt-1">
                                            {{ $hManana->consultorio->nombre ?? 'Sin Consultorio' }} • {{ $hManana->especialidad->nombre ?? 'Sin Especialidad' }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if($hTarde)
                                <div class="flex items-start gap-3 p-3 rounded-lg bg-orange-50/50 border border-orange-100">
                                    <div class="bg-orange-100 text-orange-600 p-2 rounded-md">
                                        <i class="bi bi-sunset-fill"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-orange-900">Tarde ({{ \Carbon\Carbon::parse($hTarde->horario_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($hTarde->horario_fin)->format('H:i') }})</p>
                                        <p class="text-xs text-orange-700 mt-1">
                                            {{ $hTarde->consultorio->nombre ?? 'Sin Consultorio' }} • {{ $hTarde->especialidad->nombre ?? 'Sin Especialidad' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        

                        <!-- STATE 3: EDITING FORM -->
                        <div x-show="editing" x-transition class="space-y-6">
                            
                            <!-- Turno Mañana Toggle -->
                            <div class="border-l-4 border-blue-500 pl-4">
                                <label class="flex items-center gap-2 mb-3 cursor-pointer">
                                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="horarios[{{ $key }}][manana_activa]" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer" 
                                            value="1" x-model="manana_active" :checked="manana_active"
                                            :class="{'right-0 border-blue-600': manana_active, 'right-auto border-gray-300': !manana_active}"/>
                                        <div class="toggle-label block overflow-hidden h-5 rounded-full cursor-pointer"
                                            :class="{'bg-blue-600': manana_active, 'bg-gray-300': !manana_active}"></div>
                                    </div>
                                    <span class="font-bold text-gray-700">Turno Mañana</span>
                                </label>

                                <div x-show="manana_active" class="grid grid-cols-1 md:grid-cols-2 gap-3 animate-fade-in-down">
                                    <!-- ESPECIALIDAD PRIMERO -->
                                    <div>
                                        <label class="form-label text-xs">Especialidad</label>
                                        <select name="horarios[{{ $key }}][manana_especialidad_id]" 
                                                id="select_esp_manana_{{ $key }}"
                                                class="form-select text-sm select-especialidad"
                                                data-turno="manana"
                                                data-key="{{ $key }}"
                                                x-model="manana.especialidad_id">
                                            <option value="">Seleccione especialidad...</option>
                                            @foreach($medico->especialidades as $especialidad)
                                                <option value="{{ $especialidad->id }}"
                                                    {{ ($hManana && $hManana->especialidad_id == $especialidad->id) ? 'selected' : '' }}>
                                                    {{ $especialidad->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- CONSULTORIO DINÁMICO (cargado via JS Nativo) -->
                                    <div>
                                        <label class="form-label text-xs">Consultorio</label>
                                        <select name="horarios[{{ $key }}][manana_consultorio_id]" 
                                                id="select_cons_manana_{{ $key }}"
                                                class="form-select text-sm select-consultorio"
                                                data-selected-id="{{ $hManana ? $hManana->consultorio_id : '' }}"
                                                data-turno="manana"
                                                data-key="{{ $key }}"
                                                x-ref="mananaConsultoriosSelect"
                                                x-model="manana.consultorio_id"
                                                :disabled="!manana.especialidad_id"
                                                onchange="updateHorariosUI(this)">
                                            <option value="">Primero seleccione especialidad</option>
                                        </select>
                                    </div>
                                    <!-- HORA INICIO -->
                                    <div>
                                        <label class="form-label text-xs font-bold text-gray-600">Inicio</label>
                                        <p id="info_inicio_manana_{{ $key }}" class="text-xs mb-1 transition-all duration-200 text-gray-500">
                                            <i class="bi bi-clock"></i> Abre: <strong id="lbl_inicio_manana_{{ $key }}">--:--</strong>
                                        </p>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="bi bi-clock text-gray-400"></i>
                                            </div>
                                            <input type="time" 
                                                name="horarios[{{ $key }}][manana_inicio]" 
                                                id="input_inicio_manana_{{ $key }}"
                                                class="form-input time-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                                                data-turno="manana"
                                                data-key="{{ $key }}"
                                                value="{{ $hManana ? \Carbon\Carbon::parse($hManana->horario_inicio)->format('H:i') : '' }}">
                                        </div>
                                    </div>
                                    <!-- HORA FIN -->
                                    <div>
                                        <label class="form-label text-xs font-bold text-gray-600">Fin</label>
                                        <p id="info_fin_manana_{{ $key }}" class="text-xs mb-1 transition-all duration-200 text-gray-500">
                                            <i class="bi bi-door-closed"></i> Cierra: <strong id="lbl_fin_manana_{{ $key }}">--:--</strong>
                                        </p>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="bi bi-dash-circle text-gray-400"></i>
                                            </div>
                                            <input type="time" 
                                                name="horarios[{{ $key }}][manana_fin]" 
                                                id="input_fin_manana_{{ $key }}"
                                                class="form-input time-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                                                data-turno="manana"
                                                data-key="{{ $key }}"
                                                value="{{ $hManana ? \Carbon\Carbon::parse($hManana->horario_fin)->format('H:i') : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Turno Tarde Toggle -->
                            <div class="border-l-4 border-orange-500 pl-4">
                                <label class="flex items-center gap-2 mb-3 cursor-pointer">
                                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="horarios[{{ $key }}][tarde_activa]" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer" 
                                            value="1" x-model="tarde_active" :checked="tarde_active"
                                            :class="{'right-0 border-orange-600': tarde_active, 'right-auto border-gray-300': !tarde_active}"/>
                                        <div class="toggle-label block overflow-hidden h-5 rounded-full cursor-pointer"
                                            :class="{'bg-orange-600': tarde_active, 'bg-gray-300': !tarde_active}"></div>
                                    </div>
                                    <span class="font-bold text-gray-700">Turno Tarde</span>
                                </label>
                                
                                <div x-show="tarde_active" class="grid grid-cols-1 md:grid-cols-2 gap-3 animate-fade-in-down">
                                    <!-- ESPECIALIDAD PRIMERO -->
                                    <div>
                                        <label class="form-label text-xs">Especialidad</label>
                                        <select name="horarios[{{ $key }}][tarde_especialidad_id]" 
                                                id="select_esp_tarde_{{ $key }}"
                                                class="form-select text-sm select-especialidad"
                                                data-turno="tarde"
                                                data-key="{{ $key }}"
                                                x-model="tarde.especialidad_id">
                                            <option value="">Seleccione especialidad...</option>
                                            @foreach($medico->especialidades as $especialidad)
                                                <option value="{{ $especialidad->id }}"
                                                    {{ ($hTarde && $hTarde->especialidad_id == $especialidad->id) ? 'selected' : '' }}>
                                                    {{ $especialidad->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- CONSULTORIO DINÁMICO (cargado via JS Nativo) -->
                                    <div>
                                        <label class="form-label text-xs">Consultorio</label>
                                        <select name="horarios[{{ $key }}][tarde_consultorio_id]" 
                                                id="select_cons_tarde_{{ $key }}"
                                                class="form-select text-sm select-consultorio"
                                                data-selected-id="{{ $hTarde ? $hTarde->consultorio_id : '' }}"
                                                data-turno="tarde"
                                                data-key="{{ $key }}"
                                                x-ref="tardeConsultoriosSelect"
                                                x-model="tarde.consultorio_id"
                                                :disabled="!tarde.especialidad_id"
                                                onchange="updateHorariosUI(this)">
                                            <option value="">Primero seleccione especialidad</option>
                                        </select>
                                    </div>
                                    <!-- HORA INICIO -->
                                    <div>
                                        <label class="form-label text-xs font-bold text-gray-600">Inicio</label>
                                        <p id="info_inicio_tarde_{{ $key }}" class="text-xs mb-1 transition-all duration-200 text-gray-500">
                                            <i class="bi bi-clock"></i> Abre: <strong id="lbl_inicio_tarde_{{ $key }}">--:--</strong>
                                        </p>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="bi bi-clock text-gray-400"></i>
                                            </div>
                                            <input type="time" 
                                                name="horarios[{{ $key }}][tarde_inicio]" 
                                                id="input_inicio_tarde_{{ $key }}"
                                                class="form-input time-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                                                data-turno="tarde"
                                                data-key="{{ $key }}"
                                                value="{{ $hTarde ? \Carbon\Carbon::parse($hTarde->horario_inicio)->format('H:i') : '' }}">
                                        </div>
                                    </div>
                                    <!-- HORA FIN -->
                                    <div>
                                        <label class="form-label text-xs font-bold text-gray-600">Fin</label>
                                        <p id="info_fin_tarde_{{ $key }}" class="text-xs mb-1 transition-all duration-200 text-gray-500">
                                            <i class="bi bi-door-closed"></i> Cierra: <strong id="lbl_fin_tarde_{{ $key }}">--:--</strong>
                                        </p>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="bi bi-dash-circle text-gray-400"></i>
                                            </div>
                                            <input type="time" 
                                                name="horarios[{{ $key }}][tarde_fin]" 
                                                id="input_fin_tarde_{{ $key }}"
                                                class="form-input time-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                                                data-turno="tarde"
                                                data-key="{{ $key }}"
                                                value="{{ $hTarde ? \Carbon\Carbon::parse($hTarde->horario_fin)->format('H:i') : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Resumen Semanal -->
            <div class="card p-6 sticky top-6">
                <h4 class="font-bold text-gray-900 mb-4">Resumen Semanal</h4>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Días activos</span>
                        <span class="font-bold text-medical-600">5 de 7</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Horas semanales</span>
                        <span class="font-bold text-gray-900">36 hrs</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Cupos máximos/día</span>
                        <span class="font-bold text-success-600">~16 citas</span>
                    </div>
                </div>

                <div class="bg-medical-50 rounded-xl p-4 mb-4">
                    <p class="text-xs text-medical-700 font-medium mb-2">💡 Consejo</p>
                    <p class="text-xs text-gray-600">
                        Configure descansos de 15-30 min cada 4 horas para mantener la calidad de atención.
                    </p>
                </div>

                <button type="button" class="btn btn-outline w-full text-sm">
                    <i class="bi bi-clipboard mr-2"></i>
                    Copiar de semana anterior
                </button>
            </div>

            <!-- Plantillas Rápidas -->
            <div class="card p-6">
                <h4 class="font-bold text-gray-900 mb-4">Plantillas Rápidas</h4>
                <div class="space-y-2">
                    <button type="button" class="btn btn-sm btn-outline w-full justify-start">
                        <i class="bi bi-clock mr-2"></i>
                        Jornada Completa (8-12, 2-6)
                    </button>
                    <button type="button" class="btn btn-sm btn-outline w-full justify-start">
                        <i class="bi bi-sunrise mr-2"></i>
                        Solo Mañanas (8-12)
                    </button>
                    <button type="button" class="btn btn-sm btn-outline w-full justify-start">
                        <i class="bi bi-sunset mr-2"></i>
                        Solo Tardes (2-6)
                    </button>
                </div>
            </div>

            <!-- Vista Previa Calendario -->
            <div class="card p-6 bg-gradient-to-br from-medical-50 to-info-50">
                <h4 class="font-bold text-gray-900 mb-4">Disponibilidad</h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Lun-Mar</span>
                        <span class="text-xs badge badge-success">8 hrs/día</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Miércoles</span>
                        <span class="text-xs badge badge-gray">Cerrado</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Jueves</span>
                        <span class="text-xs badge badge-warning">4 hrs</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Viernes</span>
                        <span class="text-xs badge badge-success">8 hrs</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Fin de semana</span>
                        <span class="text-xs badge badge-gray">Cerrado</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    // Logic Nativo para Manejo de Selects del Formulario Principal
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ [Horarios Main] Inicializando lógica nativa para selects principales.');

        const especialidadSelects = document.querySelectorAll('.select-especialidad');
        
        // Función reutilizable para cargar consultorios
        async function loadConsultorios(espSelect, triggerType = 'manual') {
            const espId = espSelect.value;
            const turno = espSelect.dataset.turno;
            const key = espSelect.dataset.key;
            
            const targetId = `select_cons_${turno}_${key}`;
            const targetSelect = document.getElementById(targetId);
            
            if (!targetSelect) return;

            // Si es carga inicial (auto), y ya tiene opciones cargadas, no hacer nada para evitar parpadeos
            // (aunque en este diseño simple siempre recargamos para asegurar consistencia)
            
            if (!espId) {
                targetSelect.innerHTML = '<option value="">Primero seleccione especialidad</option>';
                targetSelect.disabled = true;
                return;
            }

            // Mostrar estado de carga solo si es cambio manual, para no ensuciar la UI al cargar página
            if (triggerType === 'manual') {
                targetSelect.innerHTML = '<option value="">Cargando...</option>';
                targetSelect.disabled = true;
            }

            try {
                // Pequeña optimización: si ya estamos cargando esto en otro request idéntico, podríamos cachear.
                // Por ahora fetch directo.
                const url = '/ajax/citas/consultorios-por-especialidad/' + espId;
                const res = await fetch(url);
                if (!res.ok) throw new Error('HTTP ' + res.status);
                
                const data = await res.json();
                
                targetSelect.innerHTML = ''; // Limpiar
                
                if (data.length === 0) {
                    targetSelect.add(new Option('Sin consultorios disponibles', ''));
                } else {
                    targetSelect.add(new Option('Seleccione consultorio...', ''));
                    data.forEach(c => {
                        const h_inicio = c.horario_inicio ? c.horario_inicio.substring(0,5) : '--:--';
                        const h_fin = c.horario_fin ? c.horario_fin.substring(0,5) : '--:--';
                        const text = `${c.nombre} (${h_inicio} - ${h_fin})`;
                        
                        // Crear opción con DATA ATTRIBUTES para las horas
                        const opt = new Option(text, c.id);
                        opt.setAttribute('data-inicio', h_inicio);
                        opt.setAttribute('data-fin', h_fin);
                        
                        targetSelect.add(opt);
                    });
                }
                
                targetSelect.disabled = false;

                // Lógica de PRECARGA / RESTAURACIÓN
                // Verificar si hay un valor guardado en el atributo data-selected-id
                const savedId = targetSelect.dataset.selectedId;
                if (savedId && triggerType === 'auto') {
                    // Verificar si el ID guardado existe en las nuevas opciones
                    const optionExists = Array.from(targetSelect.options).some(o => o.value == savedId);
                    if (optionExists) {
                        targetSelect.value = savedId;
                        console.log(`♻️ [Horarios Main] Restaurado consultorio guardado ID: ${savedId} para ${targetId}`);
                        
                        // Disparar evento para que Alpine se entere del valor inicial
                        targetSelect.dispatchEvent(new Event('input'));
                        targetSelect.dispatchEvent(new Event('change'));
                        
                        // IMPORTANTE: Limpiar el atributo para que futuros cambios manuales no se vean forzados
                        // targetSelect.removeAttribute('data-selected-id'); 
                        // (Opcional, pero a veces es mejor dejarlo si el usuario cancela edición)
                    }
                }

                // Si fue cambio manual, disparamos eventos para Alpine
                if (triggerType === 'manual') {
                    targetSelect.dispatchEvent(new Event('input'));
                    targetSelect.dispatchEvent(new Event('change'));
                }
                
                // ACTUALIZAR UI DE HORARIOS (Nativo)
                updateHorariosUI(targetSelect);

            } catch (e) {
                console.error('❌ [Horarios Main] Error Ajax:', e);
                targetSelect.innerHTML = '<option value="">Error al cargar</option>';
            }
        }
        
        // Función para actualizar textos y límites de horas
        function updateHorariosUI(selectElement) {
            const turno = selectElement.dataset.turno; // manana / tarde
            const key = selectElement.dataset.key;
            
            // Elementos de UI
            const lblInicio = document.getElementById(`lbl_inicio_${turno}_${key}`);
            const lblFin = document.getElementById(`lbl_fin_${turno}_${key}`);
            const infoInicio = document.getElementById(`info_inicio_${turno}_${key}`);
            const infoFin = document.getElementById(`info_fin_${turno}_${key}`);
            const inputInicio = document.getElementById(`input_inicio_${turno}_${key}`);
            const inputFin = document.getElementById(`input_fin_${turno}_${key}`);
            
            if (!lblInicio || !inputInicio) return;
            
            // Obtener opción seleccionada
            const selectedOpt = selectElement.options[selectElement.selectedIndex];
            
            if (!selectedOpt || !selectedOpt.value) {
                // Resetear si no hay consultorio
                lblInicio.textContent = '--:--';
                lblFin.textContent = '--:--';
                return;
            }
            
            const inicio = selectedOpt.getAttribute('data-inicio') || '00:00';
            const fin = selectedOpt.getAttribute('data-fin') || '23:59';
            
            // Actualizar textos
            lblInicio.textContent = inicio;
            lblFin.textContent = fin;
            
            // Actualizar límites inputs
            inputInicio.min = inicio;
            inputInicio.max = fin;
            inputFin.min = inicio;
            inputFin.max = fin;
            
            console.log(`⏰ [Horarios Main] Límites actualizados para ${turno} ${key}: ${inicio} - ${fin}`);
            
            // Validación visual inmediata
            validateInput(inputInicio, inicio, fin);
            validateInput(inputFin, inicio, fin);
        }
        
        function validateInput(input, min, max) {
            if (!input.value) return;
            const val = input.value;
            // Simple string compare for HH:MM works fine
            if (val < min || val > max) {
                input.classList.add('border-red-500', 'text-red-600');
            } else {
                input.classList.remove('border-red-500', 'text-red-600');
            }
        }

        // 1. Asignar Listeners para cambios manuales
        especialidadSelects.forEach(select => {
            select.addEventListener('change', function() {
                loadConsultorios(this, 'manual');
            });
            
            // 2. CHECK INICIAL: Si ya tiene valor seleccionado (desde el servidor), cargar consultorios automáticamente
            if (select.value) {
                console.log(`🚀 [Horarios Main] Precarga detectada para ${select.id}`);
                loadConsultorios(select, 'auto');
            }
        });
        
        // Listener global para inputs de hora (validacion visual en tiempo real)
        document.querySelectorAll('.time-input').forEach(input => {
            input.addEventListener('input', function() {
                const turno = this.dataset.turno;
                const key = this.dataset.key;
                // Buscar el select correspondiente para saber los límites
                // Como no tenemos referencia directa, buscamos el label
                const lblInicio = document.getElementById(`lbl_inicio_${turno}_${key}`);
                const lblFin = document.getElementById(`lbl_fin_${turno}_${key}`);
                
                if(lblInicio && lblFin) {
                    validateInput(this, lblInicio.textContent, lblFin.textContent);
                }
            });
        });
    });
</script>
@endsection
