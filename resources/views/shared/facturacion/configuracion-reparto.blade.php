@extends('layouts.admin')

@section('title', 'Configuración de Reparto')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Configuración de Reparto</h1>
            <p class="text-gray-600 mt-1">Gestionar porcentajes de reparto por médico y consultorio</p>
        </div>
        <button onclick="document.getElementById('modal-config-global').showModal()" class="btn btn-primary shadow-lg shadow-emerald-200">
            <i class="bi bi-gear-fill mr-2"></i>
            <span>Configuración Global</span>
        </button>
    </div>

    <!-- Configuración Global Actual -->
    <div class="card p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Configuración Global por Defecto</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600">{{ ConfiguracionGlobal::obtener('reparto_medico_default', 70) }}%</div>
                <div class="text-sm text-gray-600">Médico</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-emerald-600">{{ ConfiguracionGlobal::obtener('reparto_consultorio_default', 20) }}%</div>
                <div class="text-sm text-gray-600">Consultorio</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">{{ ConfiguracionGlobal::obtener('reparto_sistema_default', 10) }}%</div>
                <div class="text-sm text-gray-600">Sistema</div>
            </div>
        </div>
        <div class="mt-4 p-4 bg-blue-100 rounded-lg">
            <p class="text-sm text-blue-800">
                <i class="bi bi-info-circle mr-2"></i>
                Estos porcentajes se usarán cuando no exista una configuración específica para un médico o consultorio.
            </p>
        </div>
    </div>

    <!-- Lista de Configuraciones -->
    <div class="card">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Configuraciones Específicas</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Médico</th>
                        <th>Consultorio</th>
                        <th>% Médico</th>
                        <th>% Consultorio</th>
                        <th>% Sistema</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($configuraciones ?? [] as $config)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-person-badge text-blue-600"></i>
                                <span>{{ $config->medico->nombre_completo }}</span>
                            </div>
                        </td>
                        <td>
                            @if($config->consultorio)
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-building text-emerald-600"></i>
                                    <span>{{ $config->consultorio->nombre }}</span>
                                </div>
                            @else
                                <span class="badge badge-warning">Todos</span>
                            @endif
                        </td>
                        <td>
                            <span class="font-bold text-blue-600">{{ $config->porcentaje_medico }}%</span>
                        </td>
                        <td>
                            <span class="font-bold text-emerald-600">{{ $config->porcentaje_consultorio }}%</span>
                        </td>
                        <td>
                            <span class="font-bold text-purple-600">{{ $config->porcentaje_sistema }}%</span>
                        </td>
                        <td>
                            <span class="badge {{ $config->porcentaje_medico + $config->porcentaje_consultorio + $config->porcentaje_sistema == 100 ? 'badge-success' : 'badge-danger' }}">
                                {{ $config->porcentaje_medico + $config->porcentaje_consultorio + $config->porcentaje_sistema }}%
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $config->status ? 'badge-success' : 'badge-secondary' }}">
                                {{ $config->status ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <button onclick="editarConfiguracion({{ $config->id }})" class="btn btn-sm btn-outline">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @if($config->status)
                                <button onclick="desactivarConfiguracion({{ $config->id }})" class="btn btn-sm btn-outline text-rose-600">
                                    <i class="bi bi-pause-circle"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-inbox text-6xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-medium">No hay configuraciones específicas</p>
                                <button onclick="document.getElementById('modal-nueva-config').showModal()" class="btn btn-primary mt-4">
                                    <i class="bi bi-plus-lg mr-2"></i>
                                    Nueva Configuración
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Configuración Global -->
<dialog id="modal-config-global" class="modal backdrop-blur-sm">
    <div class="modal-box max-w-2xl">
        <h3 class="font-bold text-lg mb-4">Configuración Global por Defecto</h3>
        <form action="{{ route('facturacion.guardar-config-global') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label"><span class="label-text font-bold">% Médico</span></label>
                    <input type="number" name="reparto_medico_default" class="input" 
                           value="{{ ConfiguracionGlobal::obtener('reparto_medico_default', 70) }}" 
                           min="0" max="100" step="0.01" required>
                </div>
                <div>
                    <label class="label"><span class="label-text font-bold">% Consultorio</span></label>
                    <input type="number" name="reparto_consultorio_default" class="input" 
                           value="{{ ConfiguracionGlobal::obtener('reparto_consultorio_default', 20) }}" 
                           min="0" max="100" step="0.01" required>
                </div>
                <div>
                    <label class="label"><span class="label-text font-bold">% Sistema</span></label>
                    <input type="number" name="reparto_sistema_default" class="input" 
                           value="{{ ConfiguracionGlobal::obtener('reparto_sistema_default', 10) }}" 
                           min="0" max="100" step="0.01" required>
                </div>
            </div>
            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <i class="bi bi-exclamation-triangle mr-2"></i>
                    Los porcentajes deben sumar 100%. Esta configuración se aplicará cuando no exista una configuración específica.
                </p>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-config-global').close()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Configuración</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Modal Nueva Configuración -->
<dialog id="modal-nueva-config" class="modal backdrop-blur-sm">
    <div class="modal-box max-w-2xl">
        <h3 class="font-bold text-lg mb-4">Nueva Configuración de Reparto</h3>
        <form action="{{ route('facturacion.guardar-config-reparto') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label"><span class="label-text font-bold">Médico</span></label>
                    <select name="medico_id" class="select" required>
                        <option value="">Seleccionar médico...</option>
                        @foreach($medicos ?? [] as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label"><span class="label-text font-bold">Consultorio</span></label>
                    <select name="consultorio_id" class="select">
                        <option value="">Aplicar a todos los consultorios</option>
                        @foreach($consultorios ?? [] as $consultorio)
                        <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label"><span class="label-text font-bold">% Médico</span></label>
                    <input type="number" name="porcentaje_medico" class="input" 
                           min="0" max="100" step="0.01" required>
                </div>
                <div>
                    <label class="label"><span class="label-text font-bold">% Consultorio</span></label>
                    <input type="number" name="porcentaje_consultorio" class="input" 
                           min="0" max="100" step="0.01" required>
                </div>
                <div>
                    <label class="label"><span class="label-text font-bold">% Sistema</span></label>
                    <input type="number" name="porcentaje_sistema" class="input" 
                           min="0" max="100" step="0.01" required>
                </div>
                <div class="md:col-span-2">
                    <label class="label"><span class="label-text font-bold">Observaciones</span></label>
                    <textarea name="observaciones" class="textarea" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-nueva-config').close()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Configuración</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function editarConfiguracion(id) {
    // Implementar lógica de edición
    Swal.fire('Edición', 'Función de edición por implementar', 'info');
}

function desactivarConfiguracion(id) {
    Swal.fire({
        title: '¿Desactivar Configuración?',
        text: 'Esta configuración dejará de aplicarse',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, Desactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementar lógica de desactivación
            Swal.fire('¡Desactivada!', 'La configuración ha sido desactivada', 'success');
        }
    });
}
</script>
@endsection
