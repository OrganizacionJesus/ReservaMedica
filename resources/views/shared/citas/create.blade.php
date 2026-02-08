@extends('layouts.admin')

@section('title', 'Agendar Nueva Cita')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Premium Header with Back Button -->
    <div class="flex items-center gap-4 animate-in fade-in slide-in-from-left duration-500">
        <a href="{{ route('citas.index') }}" class="flex h-12 w-12 items-center justify-center rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-700 shadow-sm hover:shadow transition-all hover:-translate-x-1">
            <i class="bi bi-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <div class="absolute inset-0 bg-medical-500/20 blur-xl rounded-full group-hover:blur-2xl transition-all duration-500"></div>
                <div class="relative h-14 w-14 rounded-2xl bg-gradient-to-br from-medical-500 to-medical-600 flex items-center justify-center text-white shadow-lg shadow-medical-200 dark:shadow-none">
                    <i class="bi bi-calendar-plus text-2xl"></i>
                </div>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white">Agendar Nueva Cita</h1>
                <p class="text-slate-500 dark:text-gray-400 font-medium">Complete la información para programar la cita médica</p>
            </div>
        </div>
    </div>

    <!-- Step 1: Tipo de Cita (Selection Cards) -->
    <div id="step-tipo" class="animate-in fade-in slide-in-from-bottom duration-500">
        <div class="card-premium rounded-3xl p-8 border border-slate-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-medical-100 dark:bg-medical-900/30 text-medical-600 dark:text-medical-400">
                    <i class="bi bi-person-check text-lg"></i>
                </div>
                ¿Para quién es esta cita?
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button type="button" data-tipo-cita="propia" class="tipo-cita-btn group relative overflow-hidden p-8 bg-white dark:bg-gray-700/50 border-2 border-slate-200 dark:border-gray-600 rounded-2xl hover:border-blue-500 dark:hover:border-blue-400 transition-all hover:shadow-lg hover:scale-105 text-left">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="h-16 w-16 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner">
                            <i class="bi bi-person-fill text-3xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl text-slate-800 dark:text-white mb-1">Cita Propia</h4>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Para un paciente registrado o nuevo</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" data-tipo-cita="terceros" class="tipo-cita-btn group relative overflow-hidden p-8 bg-white dark:bg-gray-700/50 border-2 border-slate-200 dark:border-gray-600 rounded-2xl hover:border-emerald-500 dark:hover:border-emerald-400 transition-all hover:shadow-lg hover:scale-105 text-left">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="h-16 w-16 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner">
                            <i class="bi bi-people-fill text-3xl text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl text-slate-800 dark:text-white mb-1">Cita para Terceros</h4>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Menores de edad, discapacitados, etc.</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Formulario Principal -->
    <form action="{{ route('citas.store') }}" method="POST" id="citaForm" class="space-y-6 hidden animate-in fade-in slide-in-from-bottom duration-500" onsubmit="return validarFormulario()">
        @csrf
        <input type="hidden" name="tipo_cita" id="tipo_cita" value="">
        <input type="hidden" name="paciente_existente" id="paciente_existente" value="0">
        <input type="hidden" name="paciente_id" id="paciente_id" value="">
        <input type="hidden" name="representante_existente" id="representante_existente" value="0">
        <input type="hidden" name="representante_id" id="representante_id_hidden" value="">
        <input type="hidden" name="paciente_especial_id" id="paciente_especial_id" value="">
        <input type="hidden" name="registrar_usuario" id="registrar_usuario" value="0">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                
                <!-- BUSCADOR DE PACIENTE (Citas Propias) -->
                <div id="seccion-buscar-paciente" class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 hidden animate-in fade-in slide-in-from-left duration-300">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                            <i class="bi bi-search"></i>
                        </div>
                        Buscar Paciente
                    </h3>
                    
                    <div id="pac-buscador-container" class="form-group mb-4">
                        <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Buscar por nombre, apellido o cédula</label>
                        <div class="relative">
                            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="buscar_paciente" class="w-full px-4 py-3 pl-12 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Escriba para buscar..." autocomplete="off">
                        </div>
                        <div id="resultados-busqueda" class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-xl shadow-lg mt-1 hidden max-h-60 overflow-y-auto"></div>
                    </div>
                    
                    <!-- Alerta tipo incorrecto -->
                    <div id="alerta-tipo-incorrecto" class="hidden p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 rounded-xl mb-4">
                        <p class="text-amber-700 dark:text-amber-400 text-sm"><i class="bi bi-exclamation-triangle"></i> <span id="alerta-tipo-mensaje"></span></p>
                    </div>
                    
                    <!-- Checkbox paciente no registrado -->
                    <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-slate-100 dark:hover:bg-gray-700 mt-4 border border-slate-100 dark:border-gray-600 transition-colors">
                        <input type="checkbox" id="paciente_no_registrado" class="w-5 h-5 text-blue-600 rounded border-slate-300 dark:border-gray-600" onchange="togglePacienteNoRegistrado()">
                        <div>
                            <span class="font-medium text-slate-800 dark:text-white">El paciente NO está registrado en el sistema</span>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Marque para ingresar los datos manualmente</p>
                        </div>
                    </label>
                    
                    <!-- Paciente seleccionado -->
                    <div id="paciente_seleccionado" class="hidden mt-4">
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-emerald-200 dark:shadow-none" id="pac_iniciales">
                                    --
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-800 dark:text-white" id="pac_nombre_display">-</h4>
                                    <p class="text-sm text-slate-600 dark:text-gray-400" id="pac_documento_display">-</p>
                                </div>
                                <button type="button" onclick="limpiarPacienteSeleccionado()" class="text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition-colors">
                                    <i class="bi bi-x-lg text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DATOS PACIENTE NUEVO (Citas Propias) -->
                <div id="datos-paciente-nuevo" class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 hidden animate-in fade-in slide-in-from-left duration-300">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        Datos del Nuevo Paciente
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Primer Nombre <span class="text-rose-500">*</span></label>
                            <input type="text" name="pac_primer_nombre" id="pac_primer_nombre" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                            <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Segundo Nombre</label>
                            <input type="text" name="pac_segundo_nombre" id="pac_segundo_nombre" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Segundo nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Primer Apellido <span class="text-rose-500">*</span></label>
                            <input type="text" name="pac_primer_apellido" id="pac_primer_apellido" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Apellido" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                            <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Segundo Apellido</label>
                            <input type="text" name="pac_segundo_apellido" id="pac_segundo_apellido" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Segundo apellido" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Identificación <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2">
                                <select name="pac_tipo_documento" id="pac_tipo_documento" class="w-20 px-3 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="P">P</option>
                                </select>
                                <input type="text" name="pac_numero_documento" id="pac_numero_documento" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" placeholder="12345678" maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <span class="error-message text-rose-500 text-xs mt-1 hidden" id="pac_numero_documento_error"></span>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Fecha Nacimiento <span class="text-rose-500">*</span></label>
                            <input type="date" name="pac_fecha_nac" id="pac_fecha_nac" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" max="{{ date('Y-m-d') }}">
                            <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Género <span class="text-rose-500">*</span></label>
                            <select name="pac_genero" id="pac_genero" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                                <option value="">Seleccionar...</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                            <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Teléfono</label>
                            <div class="flex gap-2">
                                <select name="pac_prefijo_tlf" class="w-24 px-3 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                                    <option value="+58">+58</option>
                                    <option value="+57">+57</option>
                                    <option value="+1">+1</option>
                                </select>
                                <input type="tel" name="pac_numero_tlf" id="pac_numero_tlf" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" placeholder="4121234567" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10">
                            </div>
                        </div>
                        
                        <!-- Ubicación -->
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Estado <span class="text-rose-500">*</span></label>
                            <select name="pac_estado_id" id="pac_estado_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" onchange="cargarCiudadesPac(); cargarMunicipiosPac()">
                                <option value="">Seleccione...</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}">{{ $estado->estado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Ciudad</label>
                            <select name="pac_ciudad_id" id="pac_ciudad_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled>
                                <option value="">Seleccione estado primero</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Municipio</label>
                            <select name="pac_municipio_id" id="pac_municipio_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled onchange="cargarParroquiasPac()">
                                <option value="">Seleccione estado primero</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Parroquia</label>
                            <select name="pac_parroquia_id" id="pac_parroquia_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled>
                                <option value="">Seleccione municipio primero</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Dirección Detallada</label>
                            <textarea name="pac_direccion_detallada" id="pac_direccion_detallada" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm resize-none" rows="2" placeholder="Calle, avenida, edificio..."></textarea>
                        </div>
                    </div>

                    <!-- Checkbox registrar en sistema -->
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="chk_registrar_usuario" class="w-5 h-5 text-blue-600 rounded border-slate-300 dark:border-gray-600" onchange="toggleRegistrarUsuario()">
                            <div>
                                <span class="font-medium text-slate-800 dark:text-white">Registrar paciente en el sistema</span>
                                <p class="text-sm text-slate-500 dark:text-gray-400">El paciente podrá iniciar sesión con correo y contraseña</p>
                            </div>
                        </label>
                        
                        <div id="campos_registro_usuario" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Correo Electrónico <span class="text-rose-500">*</span></label>
                                <input type="email" name="pac_correo" id="pac_correo" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" placeholder="ejemplo@email.com">
                                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Contraseña (Auto-generada)</label>
                                <div class="flex gap-2">
                                    <input type="text" id="pac_password_display" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-slate-100 dark:bg-gray-600 text-slate-800 dark:text-white shadow-sm" readonly>
                                    <button type="button" onclick="copiarContrasena('pac_password_display')" class="px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-600 transition-colors">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="pac_password" id="pac_password">
                                <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Formato: #Documento+Nombre+Año</p>
                            </div>
                        </div>
                    </div>
                </div>

                @include('shared.citas.partials.seccion-terceros')
                @include('shared.citas.partials.seccion-consulta')

            </div>

            <!-- SIDEBAR RESUMEN -->
            @include('shared.citas.partials.sidebar-resumen')
        </div>
    </form>
</div>

@include('shared.citas.partials.scripts')
@endsection
