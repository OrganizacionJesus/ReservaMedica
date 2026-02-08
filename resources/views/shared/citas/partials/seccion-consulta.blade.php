<!-- SECCIÓN CONSULTA: Estado, Consultorio, Especialidad, Médico, Fecha -->
<div id="seccion-consulta" class="space-y-6 hidden">

    <!-- SELECCIÓN DE UBICACIÓN -->
    <div class="card-premium rounded-3xl p-6 lg:p-8 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-500 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute -top-10 -right-10 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3 relative z-10">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 shadow-sm">
                <i class="bi bi-geo-alt text-xl"></i>
            </div>
            <div>
                <span class="block text-sm font-normal text-slate-500 dark:text-gray-400">Paso 1</span>
                Ubicación del Consultorio
            </div>
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Estado <span class="text-rose-500">*</span></label>
                <select id="estado_id" name="estado_consulta" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors">
                    <option value="">Seleccione un estado...</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id_estado }}">{{ $estado->estado }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Consultorio <span class="text-rose-500">*</span></label>
                <select id="consultorio_id" name="consultorio_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors disabled:opacity-50" disabled onchange="cargarEspecialidades()">
                    <option value="">Seleccione estado primero...</option>
                    @foreach($consultorios as $consultorio)
                        <option value="{{ $consultorio->id }}" data-estado="{{ $consultorio->estado_id }}" style="display: none;">
                            {{ $consultorio->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- ESPECIALIDAD Y MÉDICO -->
    <div class="card-premium rounded-3xl p-6 lg:p-8 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-500 delay-100 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3 relative z-10">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 shadow-sm">
                <i class="bi bi-person-badge text-xl"></i>
            </div>
            <div>
                <span class="block text-sm font-normal text-slate-500 dark:text-gray-400">Paso 2</span>
                Especialidad y Médico
            </div>
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Especialidad <span class="text-rose-500">*</span></label>
                <select id="especialidad_id" name="especialidad_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors disabled:opacity-50" disabled onchange="cargarMedicos()">
                    <option value="">Seleccione consultorio primero...</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Médico <span class="text-rose-500">*</span></label>
                <select id="medico_id" name="medico_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors disabled:opacity-50" disabled onchange="actualizarInfoMedico()">
                    <option value="">Seleccione especialidad primero...</option>
                </select>
            </div>
        </div>
        
        <!-- Info del médico seleccionado -->
        <div id="info-medico" class="hidden mt-6 p-5 bg-gradient-to-r from-medical-50 to-purple-50 dark:from-medical-900/20 dark:to-purple-900/20 border border-medical-200 dark:border-medical-800 rounded-2xl relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-medical-500 to-medical-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-medical-200 dark:shadow-none" id="medico-iniciales">--</div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-800 dark:text-white" id="medico-nombre">-</h4>
                    <p class="text-sm text-slate-600 dark:text-gray-400" id="medico-especialidad">-</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 dark:text-gray-400 uppercase font-bold">Tarifa</p>
                    <p class="text-2xl font-black text-medical-600 dark:text-medical-400" id="medico-tarifa">$0.00</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FECHA Y HORA -->
    <div class="card-premium rounded-3xl p-6 lg:p-8 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-500 delay-200 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sky-400 to-blue-500"></div>
        <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-sky-500/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3 relative z-10">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 shadow-sm">
                <i class="bi bi-calendar-event text-xl"></i>
            </div>
            <div>
                <span class="block text-sm font-normal text-slate-500 dark:text-gray-400">Paso 3</span>
                Fecha y Hora
            </div>
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Fecha de la Cita <span class="text-rose-500">*</span></label>
                <input type="date" id="fecha_cita" name="fecha_cita" 
                       class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-sky-500 focus:ring-sky-500 shadow-sm transition-colors disabled:opacity-50" 
                       min="{{ date('Y-m-d') }}" disabled onchange="cargarHorarios()">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Hora Disponible <span class="text-rose-500">*</span></label>
                <div id="horarios-container" class="grid grid-cols-3 sm:grid-cols-4 gap-2 max-h-48 overflow-y-auto p-3 border border-slate-200 dark:border-gray-700 rounded-xl bg-slate-50 dark:bg-gray-800/50">
                    <p class="col-span-full text-center text-slate-500 dark:text-gray-400 text-sm py-4">Seleccione médico y fecha</p>
                </div>
                <input type="hidden" name="hora_inicio" id="hora_inicio" required>
            </div>
        </div>

        <!-- Leyenda de colores -->
        <div class="flex items-center justify-center gap-6 text-sm mt-4 bg-white dark:bg-gray-800/50 p-3 rounded-xl border border-slate-100 dark:border-gray-700 relative z-10">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-200"></div>
                <span class="text-slate-600 dark:text-gray-400 font-medium">Disponible</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-slate-300 dark:bg-gray-600"></div>
                <span class="text-slate-500 dark:text-gray-500">Ocupado</span>
            </div>
        </div>
    </div>

    <!-- TIPO DE CONSULTA -->
    <div class="card-premium rounded-3xl p-6 lg:p-8 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-500 delay-300 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute -top-10 left-1/2 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none -translate-x-1/2"></div>
        
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3 relative z-10">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 shadow-sm">
                <i class="bi bi-building text-xl"></i>
            </div>
            <div>
                <span class="block text-sm font-normal text-slate-500 dark:text-gray-400">Paso 4</span>
                Tipo de Consulta
            </div>
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
            <label class="cursor-pointer relative group">
                <input type="radio" name="tipo_consulta" value="Consultorio" class="peer sr-only" checked>
                
                <div class="h-full p-6 rounded-2xl border-2 border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-800/50 
                            hover:border-blue-400 dark:hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/10 hover:-translate-y-1
                            peer-checked:border-blue-500 peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-900/20 peer-checked:shadow-blue-500/20
                            transition-all duration-300 relative overflow-hidden">
                    
                    <div class="absolute top-4 right-4 opacity-0 peer-checked:opacity-100 transition-opacity">
                        <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-300">
                            <i class="bi bi-check text-sm font-bold"></i>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-inner">
                            <i class="bi bi-hospital text-2xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-lg text-slate-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">En Consultorio</span>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Asistir al consultorio médico</p>
                        </div>
                    </div>
                </div>
            </label>
            
            <label id="opcion-domicilio" class="cursor-pointer relative group hidden">
                <input type="radio" name="tipo_consulta" value="Domicilio" class="peer sr-only">
                
                <div class="h-full p-6 rounded-2xl border-2 border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-800/50 
                            hover:border-emerald-400 dark:hover:border-emerald-400 hover:shadow-lg hover:shadow-emerald-500/10 hover:-translate-y-1
                            peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 dark:peer-checked:bg-emerald-900/20 peer-checked:shadow-emerald-500/20
                            transition-all duration-300 relative overflow-hidden">
                    
                    <div class="absolute top-4 right-4 opacity-0 peer-checked:opacity-100 transition-opacity">
                        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-300">
                            <i class="bi bi-check text-sm font-bold"></i>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-inner">
                            <i class="bi bi-house-door text-2xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-lg text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">A Domicilio</span>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Visita a domicilio (tarifa extra)</p>
                        </div>
                    </div>
                </div>
            </label>
        </div>
        
        <div id="aviso-domicilio" class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl hidden relative z-10">
            <p class="text-sm text-amber-700 dark:text-amber-400"><i class="bi bi-exclamation-triangle"></i> Tarifa adicional: <strong id="tarifa-extra-valor">$0.00</strong></p>
        </div>
    </div>

    <!-- MOTIVO -->
    <div class="card-premium rounded-3xl p-6 lg:p-8 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-500 delay-400 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl pointer-events-none translate-y-1/2 translate-x-1/2"></div>
        
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3 relative z-10">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 shadow-sm">
                <i class="bi bi-chat-left-text text-xl"></i>
            </div>
            <div>
                <span class="block text-sm font-normal text-slate-500 dark:text-gray-400">Paso 5</span>
                Motivo de Consulta
            </div>
        </h3>
        
        <div class="relative z-10">
            <div class="relative group">
                <textarea name="motivo" id="motivo" rows="4" 
                          class="block px-6 pb-4 pt-4 w-full text-base text-slate-900 dark:text-white bg-slate-50 dark:bg-gray-800/50 rounded-2xl border-2 border-slate-200 dark:border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-rose-500 focus:bg-white dark:focus:bg-gray-800 transition-all resize-none shadow-inner"
                          placeholder="Describa brevemente los síntomas o el motivo de la consulta..."
                          maxlength="255"
                          oninput="document.getElementById('motivo_counter').textContent = this.value.length + '/255'"></textarea>
                
                <div class="absolute bottom-4 right-4 flex items-center gap-3 pointer-events-none">
                    <span class="text-xs font-medium text-slate-400 bg-slate-200 dark:bg-gray-700 px-2 py-1 rounded-md transition-colors group-focus-within:text-rose-500 group-focus-within:bg-rose-50 dark:group-focus-within:bg-rose-900/20" id="motivo_counter">0/255</span>
                </div>
            </div>
            
            <p class="text-xs text-slate-400 dark:text-gray-500 mt-2 ml-2">
                <i class="bi bi-info-circle mr-1"></i>
                Esta información ayudará al médico a prepararse para la consulta.
            </p>
        </div>
    </div>
</div>
