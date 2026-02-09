<!-- SIDEBAR RESUMEN -->
<div class="space-y-6">
    <div class="card-premium rounded-3xl p-6 border border-slate-200 dark:border-gray-700 sticky top-24">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                <i class="bi bi-receipt"></i>
            </div>
            Resumen de la Cita
        </h3>
        
        <div class="space-y-3 text-sm">
            <div class="p-4 bg-slate-50 dark:bg-gray-700/50 rounded-xl border border-slate-100 dark:border-gray-600">
                <p class="text-xs text-slate-500 dark:text-gray-400 uppercase font-bold mb-1">Tipo de Cita</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-tipo">-</p>
            </div>
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                <p class="text-xs text-blue-600 dark:text-blue-400 uppercase font-bold mb-1">Paciente</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-paciente">-</p>
            </div>
            <div id="resumen-representante-container" class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800 hidden">
                <p class="text-xs text-purple-600 dark:text-purple-400 uppercase font-bold mb-1">Representante</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-representante">-</p>
            </div>
            <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800">
                <p class="text-xs text-amber-600 dark:text-amber-400 uppercase font-bold mb-1">Consultorio</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-consultorio">-</p>
            </div>
            <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800">
                <p class="text-xs text-purple-600 dark:text-purple-400 uppercase font-bold mb-1">Especialidad</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-especialidad">-</p>
            </div>
            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800">
                <p class="text-xs text-emerald-600 dark:text-emerald-400 uppercase font-bold mb-1">Médico</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-medico">-</p>
            </div>
            <div class="p-4 bg-sky-50 dark:bg-sky-900/20 rounded-xl border border-sky-100 dark:border-sky-800">
                <p class="text-xs text-sky-600 dark:text-sky-400 uppercase font-bold mb-1">Fecha y Hora</p>
                <p class="font-semibold text-slate-800 dark:text-white" id="resumen-fecha">-</p>
            </div>
            <div class="p-5 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl border-2 border-emerald-200 dark:border-emerald-800">
                <p class="text-xs text-emerald-600 dark:text-emerald-400 uppercase font-bold mb-2">Tarifa Total</p>
                <p class="text-3xl font-black text-emerald-700 dark:text-emerald-400" id="resumen-tarifa">$0.00</p>
                <span class="text-xs text-slate-500 dark:text-gray-400" id="resumen-tarifa-detalle"></span>
            </div>
        </div>
        
        <div class="mt-6 space-y-3">
            <button type="submit" class="w-full px-6 py-4 rounded-xl font-bold text-white bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 shadow-lg shadow-emerald-200 dark:shadow-none hover:-translate-y-1 transition-all text-lg flex items-center justify-center gap-2">
                <i class="bi bi-check-lg text-xl"></i> Confirmar Cita
            </button>
            <button type="button" onclick="resetForm()" class="w-full px-6 py-3 rounded-xl font-bold text-slate-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-slate-200 dark:border-gray-600 hover:bg-slate-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                <i class="bi bi-arrow-left"></i> Cancelar
            </button>
        </div>

        <!-- Banner de errores de validación -->
        <div id="submit-error-banner" class="hidden p-4 bg-rose-100 dark:bg-rose-900/30 border border-rose-400 dark:border-rose-700 text-rose-700 dark:text-rose-400 rounded-xl mt-4 text-center font-bold text-sm"></div>
    </div>
</div>
