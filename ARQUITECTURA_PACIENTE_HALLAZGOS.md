# Informe de Arquitectura (Módulo Paciente)

## Alcance
Este informe revisa la **parte del Paciente** y sus dependencias directas en el proyecto (Laravel 10 / PHP 8.1):

- Portal Paciente: `routes/web.php` (prefijo `paciente/*`)
- Controladores clave:
  - `app/Http/Controllers/PacienteController.php`
  - `app/Http/Controllers/CitaController.php` (rutas paciente)
  - `app/Http/Controllers/PagoController.php` (rutas paciente)
  - `app/Http/Controllers/AuthController.php` (login/registro/recuperación)
  - `app/Http/Controllers/Paciente/PacienteNotificationController.php`
- Modelos clave:
  - `app/Models/Usuario.php`
  - `app/Models/Paciente.php`

> Nota: El sistema tiene lógica transversal (admin/médico/paciente) dentro de los mismos controladores. Eso se considera en el análisis porque impacta directamente seguridad y mantenibilidad.

---

## Mapa funcional (flujo Paciente)

### Puntos de entrada (rutas)
En `routes/web.php`:

- `GET /paciente/dashboard` -> `PacienteController@dashboard`
- `GET /paciente/historial` -> `PacienteController@historial`
- `GET /paciente/pagos` -> `PacienteController@pagos`
- `GET /paciente/citas` -> `CitaController@index`
- `GET /paciente/citas/{id}` -> `CitaController@show`
- `GET /paciente/citas/{id}/comprobante` -> `CitaController@comprobante`
- `GET /paciente/citas/create` -> `CitaController@create`
- `POST /paciente/citas` -> `CitaController@store`
- `GET /paciente/pagos/registrar/{cita}` -> `PagoController@mostrarRegistroPago`
- `POST /paciente/pagos/registrar` -> `PagoController@registrarPagoPaciente`
- `GET /paciente/perfil/editar` -> `PacienteController@editPerfil`
- `PUT /paciente/perfil` -> `PacienteController@updatePerfil`
- Notificaciones:
  - `GET /paciente/notificaciones` -> `PacienteNotificationController@index`

### Entidades relevantes
- `Usuario` (autenticación) con `rol_id` (1 admin, 2 médico, 3 paciente) y `status` (0 inactivo, 1 activo, 2 bloqueado).
- `Paciente` (perfil) con datos personales + `status` (aparenta boolean, pero se usa de forma mixta).
- `Cita` (no revisado modelo completo aquí) + relaciones a `Paciente`, `Medico`, `FacturaPaciente`.
- `Representante` + `PacienteEspecial` (para citas/pagos/historial de terceros).

---

## Hallazgos principales (priorizados)

### CRÍTICO

#### 1) Rutas “temporales/debug” expuestas públicamente (sin `auth` ni `env`)
- Evidencia (en `routes/web.php`):
  - `GET /force-reset-questions` resetea preguntas de seguridad de un usuario específico.
  - `GET /test-user-search/{email}` expone datos de usuario y preguntas.
  - `GET /fix-payment-methods` modifica datos en DB.
- Impacto:
  - **Backdoor operativo**: cualquiera podría ejecutar acciones administrativas o extraer información.
  - Riesgo legal: exposición de PII/PHI (datos de pacientes) + manipulación de seguridad.
- Recomendación:
  - Eliminar estas rutas o protegerlas con:
    - `app()->environment('local')` + `auth` + `role:admin`.

#### 2) Control de acceso defectuoso en `CitaController@show()` para rol paciente
- Evidencia:
  - Se calculan `$esPropia`/`$esTercero` pero **no se usan para abortar**.
  - Retorna `view('paciente.citas.show', compact('cita'))` sin negar acceso.
- Impacto:
  - Un paciente podría acceder a `/paciente/citas/{id}` y ver datos de citas de otros pacientes por enumeración de IDs.
  - Además el `with()` carga `paciente.historiaClinicaBase`, potencial exposición de información clínica.
- Recomendación:
  - Aplicar autorización estricta:
    - Si no es propia ni es de un representado: `abort(403)`.
  - Implementar esto como **Policy** (ej. `CitaPolicy@view`) y usar `$this->authorize('view', $cita)`.

#### 3) Restricción no modificable: uso de `md5(md5())` para contraseñas
- Evidencia:
  - `Usuario::setPasswordAttribute()` aplica `md5(md5($value))`.
  - `AuthController@login()` compara hash MD5 manualmente.
- Impacto:
  - Riesgo elevado ante fuga de base de datos (hash rápido, sin sal).
- Restricción:
  - Por requerimiento explícito, **no se cambiará el mecanismo MD5**.
- Mitigaciones recomendadas (compatibles con mantener MD5):
  - Aplicar **rate-limiting** a login y recovery (por IP/usuario).
  - Reforzar políticas de contraseña (longitud, complejidad) y bloqueo por intentos.
  - Proteger/rotar secrets, asegurar TLS, y endurecer logging para no exponer credenciales/answers.
  - Auditoría y alertas ante patrones anómalos (intentos masivos, enumeración).

---

### ALTO

#### 4) Rutas de Paciente solo tienen `auth`, no `role:paciente`
- Evidencia:
  - Grupo `Route::prefix('paciente')->middleware(['auth'])->group(...)`.
  - Existe middleware `CheckRole` con alias `role` en `Kernel`, pero no se utiliza aquí.
- Impacto:
  - Dependen de checks dispersos en controladores (a veces presentes, a veces no).
  - Aumenta superficie de bugs de autorización (como el caso de `CitaController@show`).
- Recomendación:
  - En el grupo `paciente/*` aplicar `middleware(['auth','role:paciente'])`.
  - Para flujos donde un paciente representante gestiona terceros, seguir siendo paciente (el rol no cambia).

#### 5) Logging de información sensible (PII y credenciales/preguntas)
- Evidencia:
  - `AuthController@verifySecurityAnswers()` registra:
    - `input_raw`, `generated_*_hash`, etc.
  - `PacienteController@updateSecurityQuestions()` registra:
    - `raw_input` y hashes.
  - `CitaController@store()` hace `Log::info(... 'data' => $request->all())`.
- Impacto:
  - Los logs se vuelven una segunda base de datos con datos sensibles.
  - Riesgo de auditoría/filtración.
- Recomendación:
  - Eliminar logs de inputs sensibles.
  - Usar logging mínimo (IDs correlativos, estado de proceso), y mascar/censurar campos.



### MEDIO

#### 7) Controladores con responsabilidades mezcladas (dificulta evolucionar)
- Evidencia:
  - `PacienteController` contiene:
    - Dashboard/historial/pagos/perfil del paciente.
    - Listado/CRUD de pacientes para admin/médico.
    - Historia clínica base.
    - Preguntas de seguridad.
- Impacto:
  - Código grande, difícil de testear.
  - Alta probabilidad de regresiones y de fallas de seguridad por cambios laterales.
- Recomendación:
  - Separar por bounded contexts:
    - `Paciente\DashboardController`
    - `Paciente\PerfilController`
    - `Admin\PacientesController` / `Medico\PacientesController`
  - Extraer lógica a **Services** (dominio) o **Actions**.

#### 8) Consultas pesadas por uso de `get()` + `map()` + paginación manual
- Evidencia:
  - `PacienteController@historial()` y `pagos()`:
    - Cargan colecciones completas y luego crean `LengthAwarePaginator` manual.
  - `CitaController@index` para paciente:
    - `get()` de todas las citas propias y de terceros, luego concat.
- Impacto:
  - No escala con muchos registros.
  - Alto uso de memoria/CPU y tiempos de respuesta.
- Recomendación:
  - Replantear la consulta para paginar desde base de datos:
    - Dos queries paginadas separadas con tabs.
    - O unificar con un `whereIn(paciente_id, ...)` y un campo calculado para “propia/terceros”.

#### 9) Posibles N+1 queries
- Evidencia:
  - `PacienteController@index` (rol médico) itera pacientes y por cada uno ejecuta query de última cita.
- Recomendación:
  - Resolver con subquery / eager-loading con `latestOfMany()` o join/aggregate.

#### 10) Upload de comprobantes sin validación de archivo en `registrarPagoPaciente`
- Evidencia:
  - Se maneja `$request->hasFile('comprobante')` pero el validator no valida `comprobante`.
- Impacto:
  - Podrían subirse archivos peligrosos/no deseados (tamaño/mime).
- Recomendación:
  - Agregar reglas: `nullable|file|mimes:pdf,jpg,jpeg,png|max:2048`.
  - Usar `$file->hashName()` en vez de `getClientOriginalName()`.

---

### BAJO / DEUDA TÉCNICA

#### 11) Inconsistencia del campo `status` (boolean vs int)
- Evidencia:
  - En varias partes se usa `whereIn('status', [true, 1])`.
  - `Usuario.status` es int (0/1/2), `Paciente.status` parece boolean.
- Recomendación:
  - Normalizar con casts en modelos y convención única.

#### 12) `Kernel` mezcla `middlewareAliases` y `routeMiddleware`
- Evidencia:
  - `Kernel.php` define ambos.
- Impacto:
  - Confusión de configuración y mantenimiento.
- Recomendación:
  - Mantener una sola fuente (en Laravel 10, preferir `middlewareAliases`).

---

## Quick wins (acciones que mejoran mucho con poco riesgo)

- **[Bloquear exposición de datos]** Corregir `CitaController@show()` para abortar si el paciente no es dueño ni representante.
- **[Eliminar backdoors]** Eliminar/proteger `/force-reset-questions`, `/test-user-search/{email}`, `/fix-payment-methods`.
- **[Endurecer rutas]** Agregar `role:paciente` a todo el grupo `paciente/*`.
- **[Higiene de logs]** Remover logs de inputs sensibles (preguntas/answers y payloads completos).
- **[Validar uploads]** Validación y almacenamiento seguro del archivo `comprobante`.

---

## Roadmap recomendado (arquitectura)

### Fase 1 (Seguridad y cumplimiento) — 1 a 3 días
- Cerrar backdoors y rutas temporales.
- Policies para `Cita`, `Factura/Pago`, `Historia Clínica`.
- Role middleware consistente.

### Fase 2 (Autenticación robusta) — 3 a 7 días
- Mantener `md5(md5())` por requerimiento y reforzar mitigaciones alrededor.
- Pruebas de login/registro/recuperación.

### Fase 3 (Escalabilidad y mantenibilidad) — 1 a 2 semanas
- Separar controladores por contexto.
- Extraer Services/Actions.
- Reescribir listados con paginación real y evitar `get()` masivo.

---

## Conclusión
El módulo Paciente tiene buena cobertura funcional (citas, pagos, perfil, representante/terceros), pero hoy está expuesto a **riesgos críticos de seguridad** (rutas temporales públicas y autorización incompleta, además de manejo de logs). Dado que el hashing MD5 es una restricción no modificable, la prioridad debería ser **cerrar exposición de datos** y **endurecer autenticación/autorización y controles operativos** (rate-limit, bloqueo, auditoría), y luego abordar deuda técnica (separación de capas, performance, N+1, paginación).
