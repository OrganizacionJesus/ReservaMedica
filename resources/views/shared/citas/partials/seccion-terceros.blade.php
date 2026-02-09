<!-- SECCIÓN TERCEROS: Representante + Paciente Especial -->
<div id="seccion-terceros" class="hidden space-y-6">

    <!-- BUSCADOR DE REPRESENTANTE -->
    <div id="seccion-buscar-representante" class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-300">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                <i class="bi bi-person-badge"></i>
            </div>
            Representante (Quien agenda)
        </h3>
        
        <div id="rep-buscador-container" class="form-group mb-4">
            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Buscar representante existente</label>
            <div class="relative">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="buscar_representante" class="w-full px-4 py-3 pl-12 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Buscar por nombre o cédula..." autocomplete="off">
            </div>
            <div id="resultados-representante" class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-xl shadow-lg mt-1 hidden max-h-60 overflow-y-auto"></div>
        </div>
        
        <!-- Checkbox representante no registrado -->
        <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-slate-100 dark:hover:bg-gray-700 border border-slate-100 dark:border-gray-600 transition-colors">
            <input type="checkbox" id="representante_no_registrado" class="w-5 h-5 text-purple-600 rounded border-slate-300 dark:border-gray-600" onchange="toggleRepresentanteNoRegistrado()">
            <div>
                <span class="font-medium text-slate-800 dark:text-white">El representante NO está registrado</span>
                <p class="text-sm text-slate-500 dark:text-gray-400">Ingresar datos manualmente</p>
            </div>
        </label>
        
        <!-- Representante seleccionado -->
        <div id="representante_seleccionado" class="hidden mt-4">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-emerald-200 dark:shadow-none" id="rep_iniciales_display">
                        --
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 dark:text-white" id="rep_nombre_display">-</h4>
                        <p class="text-sm text-slate-600 dark:text-gray-400" id="rep_documento_display">-</p>
                    </div>
                    <button type="button" onclick="limpiarRepresentanteSeleccionado()" class="text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- DATOS REPRESENTANTE NUEVO -->
    <div id="datos-representante-nuevo" class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 hidden animate-in fade-in slide-in-from-left duration-300">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                <i class="bi bi-person-plus"></i>
            </div>
            Datos del Representante
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Primer Nombre <span class="text-rose-500">*</span></label>
                <input type="text" name="rep_primer_nombre" id="rep_primer_nombre" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Segundo Nombre</label>
                <input type="text" name="rep_segundo_nombre" id="rep_segundo_nombre" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Segundo nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Primer Apellido <span class="text-rose-500">*</span></label>
                <input type="text" name="rep_primer_apellido" id="rep_primer_apellido" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Apellido" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Segundo Apellido</label>
                <input type="text" name="rep_segundo_apellido" id="rep_segundo_apellido" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Segundo apellido" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Identificación <span class="text-rose-500">*</span></label>
                <div class="flex gap-2">
                    <select name="rep_tipo_documento" id="rep_tipo_documento" class="w-20 px-3 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                        <option value="V">V</option>
                        <option value="E">E</option>
                        <option value="P">P</option>
                    </select>
                    <input type="text" name="rep_numero_documento" id="rep_numero_documento" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" placeholder="12345678" maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <span class="error-message text-rose-500 text-xs mt-1 hidden" id="rep_numero_documento_error"></span>
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Teléfono</label>
                <div class="flex gap-2">
                    <select name="rep_prefijo_tlf" class="w-24 px-3 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                        <option value="+58">+58</option>
                        <option value="+57">+57</option>
                        <option value="+1">+1</option>
                    </select>
                    <input type="tel" name="rep_numero_tlf" id="rep_numero_tlf" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" placeholder="4121234567" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Fecha Nacimiento <span class="text-rose-500">*</span></label>
                <input type="date" name="rep_fecha_nac" id="rep_fecha_nac" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" max="{{ date('Y-m-d') }}" onchange="if(document.getElementById('chk_registrar_representante').checked) generarContrasena('rep')">
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Género <span class="text-rose-500">*</span></label>
                <select name="rep_genero" id="rep_genero" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                    <option value="">Seleccionar...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            
            <!-- Ubicación Representante -->
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Estado <span class="text-rose-500">*</span></label>
                <select name="rep_estado_id" id="rep_estado_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" onchange="cargarCiudadesRep(); cargarMunicipiosRep()">
                    <option value="">Seleccione...</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id_estado }}">{{ $estado->estado }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Ciudad</label>
                <select name="rep_ciudad_id" id="rep_ciudad_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled>
                    <option value="">Seleccione estado primero</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Municipio <span class="text-rose-500">*</span></label>
                <select name="rep_municipio_id" id="rep_municipio_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled onchange="cargarParroquiasRep()">
                    <option value="">Seleccione estado primero</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Parroquia <span class="text-rose-500">*</span></label>
                <select name="rep_parroquia_id" id="rep_parroquia_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled>
                    <option value="">Seleccione municipio primero</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Dirección Detallada</label>
                <textarea name="rep_direccion_detallada" id="rep_direccion_detallada" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm resize-none" rows="2" placeholder="Calle, avenida, edificio..."></textarea>
            </div>
            
            <div class="md:col-span-2">
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Parentesco con el Paciente <span class="text-rose-500">*</span></label>
                <select name="rep_parentesco" id="rep_parentesco" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                    <option value="">Seleccionar parentesco...</option>
                    <option value="Padre">Padre</option>
                    <option value="Madre">Madre</option>
                    <option value="Hijo/a">Hijo/a</option>
                    <option value="Hermano/a">Hermano/a</option>
                    <option value="Abuelo/a">Abuelo/a</option>
                    <option value="Tutor">Tutor Legal</option>
                    <option value="Otro">Otro</option>
                </select>
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
        </div>
        
        <!-- Checkbox registrar representante -->
        <div class="mt-6 p-4 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="chk_registrar_representante" id="chk_registrar_representante" class="w-5 h-5 text-purple-600 rounded border-slate-300 dark:border-gray-600" onchange="toggleRegistrarRepresentante()">
                <div>
                    <span class="font-medium text-slate-800 dark:text-white">Registrar representante en el sistema</span>
                    <p class="text-sm text-slate-500 dark:text-gray-400">Podrá iniciar sesión y agendar citas</p>
                </div>
            </label>
            
            <div id="campos_registro_representante" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Correo Electrónico <span class="text-rose-500">*</span></label>
                    <input type="email" name="rep_correo" id="rep_correo" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" placeholder="ejemplo@email.com">
                    <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Contraseña (Auto-generada)</label>
                    <div class="flex gap-2">
                        <input type="text" id="rep_password_display" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-slate-100 dark:bg-gray-600 text-slate-800 dark:text-white shadow-sm" readonly>
                        <button type="button" onclick="copiarContrasena('rep_password_display')" class="px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <input type="hidden" name="rep_password" id="rep_password">
                </div>
            </div>
        </div>
    </div>

    <!-- BUSCADOR DE PACIENTE ESPECIAL -->
    <div id="seccion-buscar-paciente-especial" class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 animate-in fade-in slide-in-from-left duration-300">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400">
                <i class="bi bi-person-heart"></i>
            </div>
            Paciente Especial
        </h3>
        
        <!-- SELECT PACIENTES ESPECIALES DEL REPRESENTANTE (cargado dinámicamente) -->
        <div id="seccion-select-pac-esp-representante" class="hidden mb-4">
            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl">
                <label class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase ml-1 mb-1.5 flex items-center gap-2">
                    <i class="bi bi-person-check"></i>
                    Pacientes registrados de este representante
                </label>
                <select id="select_pac_esp_representante" class="w-full px-4 py-3 mt-2 rounded-xl border-emerald-200 dark:border-emerald-700 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" onchange="seleccionarPacEspDeRepresentante(this.value)">
                    <option value="">Seleccionar paciente...</option>
                </select>
            </div>
        </div>
        
        <!-- Mensaje cuando no hay representante seleccionado o no tiene pacientes -->
        <div id="mensaje-seleccionar-representante" class="p-4 bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-700 rounded-xl mb-4">
            <p class="text-slate-600 dark:text-gray-400 text-sm flex items-center gap-2">
                <i class="bi bi-info-circle text-slate-400"></i>
                <span>Seleccione o ingrese un representante primero para ver sus pacientes registrados.</span>
            </p>
        </div>
        
        <!-- Alerta tipo incorrecto -->
        <div id="alerta-pac-especial" class="hidden p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 rounded-xl mb-4">
            <p class="text-amber-700 dark:text-amber-400 text-sm"><i class="bi bi-exclamation-triangle"></i> <span id="alerta-pac-especial-mensaje"></span></p>
        </div>
        
        <!-- Checkbox paciente especial no registrado -->
        <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-slate-100 dark:hover:bg-gray-700 border border-slate-100 dark:border-gray-600 transition-colors">
            <input type="checkbox" id="pac_especial_no_registrado" class="w-5 h-5 text-rose-600 rounded border-slate-300 dark:border-gray-600" onchange="togglePacEspecialNoRegistrado()">
            <div>
                <span class="font-medium text-slate-800 dark:text-white">El paciente especial NO está registrado</span>
                <p class="text-sm text-slate-500 dark:text-gray-400">Ingresar datos manualmente</p>
            </div>
        </label>
        
        <!-- Paciente especial seleccionado -->
        <div id="pac_especial_seleccionado" class="hidden mt-4">
            <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 rounded-xl p-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-rose-200 dark:shadow-none" id="pac_esp_iniciales">
                        --
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 dark:text-white" id="pac_esp_nombre_display">-</h4>
                        <p class="text-sm text-slate-600 dark:text-gray-400" id="pac_esp_documento_display">-</p>
                    </div>
                    <button type="button" onclick="limpiarPacEspecialSeleccionado()" class="text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- DATOS PACIENTE ESPECIAL NUEVO -->
    <div id="datos-paciente-especial-nuevo" class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 hidden animate-in fade-in slide-in-from-left duration-300">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400">
                <i class="bi bi-person-plus"></i>
            </div>
            Datos del Paciente Especial
        </h3>
        
        <!-- Tipo de Paciente -->
        <div class="mb-6">
            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-2 block">Tipo de Paciente <span class="text-rose-500">*</span></label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                <label class="flex items-center gap-2 p-3 border-2 border-slate-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-rose-50 dark:hover:bg-rose-900/20 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/20 transition-all">
                    <input type="radio" name="pac_esp_tipo" value="Menor de Edad" class="text-rose-600">
                    <span class="text-sm font-medium text-slate-700 dark:text-gray-300">Menor de Edad</span>
                </label>
                <label class="flex items-center gap-2 p-3 border-2 border-slate-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-rose-50 dark:hover:bg-rose-900/20 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/20 transition-all">
                    <input type="radio" name="pac_esp_tipo" value="Discapacitado" class="text-rose-600">
                    <span class="text-sm font-medium text-slate-700 dark:text-gray-300">Discapacitado</span>
                </label>
                <label class="flex items-center gap-2 p-3 border-2 border-slate-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-rose-50 dark:hover:bg-rose-900/20 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/20 transition-all">
                    <input type="radio" name="pac_esp_tipo" value="Anciano" class="text-rose-600">
                    <span class="text-sm font-medium text-slate-700 dark:text-gray-300">Adulto Mayor</span>
                </label>
                <label class="flex items-center gap-2 p-3 border-2 border-slate-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-rose-50 dark:hover:bg-rose-900/20 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/20 transition-all">
                    <input type="radio" name="pac_esp_tipo" value="Otro" class="text-rose-600">
                    <span class="text-sm font-medium text-slate-700 dark:text-gray-300">Otro</span>
                </label>
            </div>
            <span class="error-message text-rose-500 text-xs mt-1 hidden" id="pac_esp_tipo_error"></span>
        </div>
        
        <!-- ¿Tiene documento? -->
        <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
            <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-3 block">¿El paciente tiene documento de identidad? <span class="text-rose-500">*</span></label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 p-3 border-2 bg-white dark:bg-gray-700 border-slate-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-green-50 dark:hover:bg-green-900/20 has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-900/20 transition-all">
                    <input type="radio" name="pac_esp_tiene_documento" value="si" class="text-green-600" onchange="togglePacEspDocumento(true)">
                    <span class="font-medium text-slate-700 dark:text-gray-300">Sí, tiene documento</span>
                </label>
                <label class="flex items-center gap-2 p-3 border-2 bg-white dark:bg-gray-700 border-slate-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-orange-50 dark:hover:bg-orange-900/20 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 dark:has-[:checked]:bg-orange-900/20 transition-all">
                    <input type="radio" name="pac_esp_tiene_documento" value="no" class="text-orange-600" onchange="togglePacEspDocumento(false)">
                    <span class="font-medium text-slate-700 dark:text-gray-300">No tiene documento</span>
                </label>
            </div>
            
            <div id="pac-esp-doc-generado-info" class="mt-3 p-3 bg-white dark:bg-gray-700 rounded-xl border border-amber-300 dark:border-amber-700 hidden">
                <p class="text-sm text-amber-800 dark:text-amber-400"><i class="bi bi-info-circle"></i> Se generará el identificador:</p>
                <p class="text-lg font-bold text-amber-900 dark:text-amber-300 mt-1" id="pac-esp-documento-preview">-</p>
                <input type="hidden" name="pac_esp_numero_documento_generado" id="pac_esp_numero_documento_generado">
            </div>
            <span class="error-message text-rose-500 text-xs mt-1 hidden" id="pac_esp_tiene_documento_error"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Primer Nombre <span class="text-rose-500">*</span></label>
                <input type="text" name="pac_esp_primer_nombre" id="pac_esp_primer_nombre" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Segundo Nombre</label>
                <input type="text" name="pac_esp_segundo_nombre" id="pac_esp_segundo_nombre" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Segundo nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Primer Apellido <span class="text-rose-500">*</span></label>
                <input type="text" name="pac_esp_primer_apellido" id="pac_esp_primer_apellido" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Apellido" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Segundo Apellido</label>
                <input type="text" name="pac_esp_segundo_apellido" id="pac_esp_segundo_apellido" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm transition-colors" placeholder="Segundo apellido" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
            </div>
            
            <!-- Documento Paciente Especial (manual) -->
            <div id="campo-documento-pac-esp" class="hidden md:col-span-2">
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Documento de Identidad <span class="text-rose-500">*</span></label>
                <div class="flex gap-2">
                    <select name="pac_esp_tipo_documento" id="pac_esp_tipo_documento" class="w-20 px-3 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                        <option value="V">V</option>
                        <option value="E">E</option>
                        <option value="P">P</option>
                    </select>
                    <input type="text" name="pac_esp_numero_documento" id="pac_esp_numero_documento" class="flex-1 px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" 
                           placeholder="Número" maxlength="12"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <span class="error-message text-rose-500 text-xs mt-1 hidden" id="pac_esp_numero_documento_error"></span>
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Fecha Nacimiento <span class="text-rose-500">*</span></label>
                <input type="date" name="pac_esp_fecha_nac" id="pac_esp_fecha_nac" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" max="{{ date('Y-m-d') }}">
                <span class="error-message text-rose-500 text-xs mt-1 hidden"></span>
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Género <span class="text-rose-500">*</span></label>
                <select name="pac_esp_genero" id="pac_esp_genero" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm">
                    <option value="">Seleccionar...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
        
            <!-- Ubicación Paciente Especial -->
            <div class="md:col-span-2 mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-gray-700 pt-4">
                <div class="md:col-span-2">
                     <h4 class="font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-2">
                         <i class="bi bi-geo-alt text-rose-500"></i>
                         Ubicación del Paciente
                     </h4>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Estado <span class="text-rose-500">*</span></label>
                    <select name="pac_esp_estado_id" id="pac_esp_estado_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm" onchange="cargarMunicipiosPacEsp(); cargarCiudadesPacEsp()">
                        <option value="">Seleccione...</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id_estado }}">{{ $estado->estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Ciudad</label>
                    <select name="pac_esp_ciudad_id" id="pac_esp_ciudad_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled>
                        <option value="">Seleccione estado primero</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Municipio <span class="text-rose-500">*</span></label>
                    <select name="pac_esp_municipio_id" id="pac_esp_municipio_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled onchange="cargarParroquiasPacEsp()">
                        <option value="">Seleccione estado primero</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Parroquia <span class="text-rose-500">*</span></label>
                    <select name="pac_esp_parroquia_id" id="pac_esp_parroquia_id" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm disabled:opacity-50" disabled>
                        <option value="">Seleccione municipio primero</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-gray-300 uppercase ml-1 mb-1.5 block">Dirección Detallada</label>
                    <textarea name="pac_esp_direccion_detallada" id="pac_esp_direccion_detallada" class="w-full px-4 py-3 rounded-xl border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-800 dark:text-white focus:border-medical-500 focus:ring-medical-500 shadow-sm resize-none" rows="2" placeholder="Calle, avenida, edificio..."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
