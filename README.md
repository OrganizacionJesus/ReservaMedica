# 🏥 ReservaMedica - Sistema de Gestión Médica

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
</p>

## 📋 Descripción General

**ReservaMedica** es una aplicación web completa desarrollada en **Laravel 10** para la gestión integral de clínicas médicas. El sistema permite administrar citas, historias clínicas electrónicas, órdenes médicas, facturación multi-moneda y notificaciones en tiempo real.

### 🎯 Características Principales

- ✅ **Gestión de Citas Médicas** - Reserva, cancelación y seguimiento
- 📋 **Historia Clínica Electrónica** - Registro completo de evoluciones clínicas
- 💊 **Órdenes Médicas** - Recetas, exámenes, imagenología y referencias
- 💰 **Sistema de Facturación** - Multi-moneda (Bs/USD) con reparto de comisiones
- 👥 **Gestión de Usuarios** - Administradores, Médicos, Pacientes y Representantes
- 🔔 **Notificaciones** - Email y notificaciones en tiempo real
- 📊 **Reportes y Estadísticas** - Análisis completo de operaciones
- 🔐 **Sistema de Seguridad** - Autenticación, permisos y auditoría

---

## 🚀 Stack Tecnológico

### Backend
| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **PHP** | ^8.1 | Lenguaje principal |
| **Laravel** | ^10.10 | Framework MVC |
| **MySQL** | 8.0+ | Base de datos |
| **Laravel Sanctum** | ^3.3 | Autenticación API |
| **Laravel Reverb** | ^1.7 | WebSockets en tiempo real |
| **Guzzle HTTP** | ^7.2 | Cliente HTTP |
| **DomPDF** | ^3.1 | Generación de PDFs |
| **Maatwebsite Excel** | ^1.1 | Exportación de reportes |

### Frontend
| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **Vite** | ^5.4 | Bundler de assets |
| **TailwindCSS** | ^3.4 | Framework CSS |
| **Alpine.js** | Latest | Interactividad reactiva |
| **Axios** | ^1.7 | Peticiones AJAX |
| **Pusher.js** | ^8.4 | WebSockets cliente |
| **Laravel Echo** | ^2.3 | Cliente WebSockets |

---

## 📦 Instalación

### Requisitos Previos

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM o Yarn

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/tu-usuario/ReservaMedica.git
cd ReservaMedica
```

2. **Instalar dependencias de PHP**
```bash
composer install
```

3. **Instalar dependencias de Node**
```bash
npm install
```

4. **Configurar archivo de entorno**
```bash
cp .env.example .env
```

5. **Generar key de aplicación**
```bash
php artisan key:generate
```

6. **Configurar base de datos**

Editar el archivo `.env` con tus credenciales de MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reservamedica
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

7. **Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

8. **Compilar assets**
```bash
npm run dev
```

9. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en: `http://127.0.0.1:8000`

---

## 👥 Roles del Sistema

| Rol | Descripción | Portal de Acceso |
|-----|-------------|------------------|
| **Administrador** | Acceso total al sistema | `/login?rol=admin` |
| **Médico** | Gestión de agenda, consultas y órdenes | `/login?rol=medico` |
| **Paciente** | Reserva de citas y consulta de historial | `/login?rol=paciente` |
| **Representante** | Gestión de citas para pacientes especiales | `/login?rol=paciente` |

### Credenciales por Defecto (Desarrollo)

**Administrador:**
- Email: `admin@reservamedica.com`
- Password: `Admin123!`

**Médico:**
- Email: `medico@reservamedica.com`
- Password: `Medico123!`

**Paciente:**
- Email: `paciente@reservamedica.com`
- Password: `Paciente123!`

> ⚠️ **IMPORTANTE**: Cambiar estas credenciales en producción

---

## 🗂️ Estructura del Proyecto

```
ReservaMedica/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # 21 controladores principales
│   │   │   ├── Admin/           # Controladores de administración
│   │   │   ├── Paciente/        # Controladores de paciente
│   │   │   ├── AuthController.php
│   │   │   ├── CitaController.php
│   │   │   ├── MedicoController.php
│   │   │   ├── HistoriaClinicaController.php
│   │   │   ├── OrdenMedicaController.php
│   │   │   ├── FacturacionController.php
│   │   │   └── PagoController.php
│   │   └── Middleware/          # Middlewares personalizados
│   ├── Models/                  # 46 modelos Eloquent
│   ├── Helpers/helpers.php      # Funciones helper globales
│   └── Notifications/           # Notificaciones por email
├── database/
│   ├── migrations/              # 68 archivos de migración
│   └── seeders/                 # Datos de prueba
├── resources/
│   └── views/                   # Vistas Blade
│       ├── admin/               # Vistas administrativas
│       ├── medico/              # Vistas para médicos
│       ├── paciente/            # Vistas para pacientes
│       ├── shared/              # Componentes reutilizables
│       ├── layouts/             # Layouts principales
│       └── emails/              # Plantillas de correo
└── routes/
    ├── web.php                  # Rutas web
    └── api.php                  # Rutas API
```

---

## 📚 Módulos Principales

### 1️⃣ Gestión de Citas Médicas

**Funcionalidades:**
- Reserva de citas por especialidad, médico y consultorio
- Filtrado dinámico de horarios disponibles
- Citas a domicilio
- Citas para terceros (representantes legales)
- Sistema de cancelación y reprogramación
- Notificaciones automáticas

**Flujo de creación:**
1. Selección de ubicación (Estado)
2. Selección de consultorio
3. Selección de especialidad
4. Selección de médico
5. Selección de fecha y hora
6. Confirmación y registro de pago

### 2️⃣ Historia Clínica Electrónica

**Componentes:**
- **Historia Base**: Tipo de sangre, alergias, antecedentes familiares, hábitos
- **Evolución Clínica**: Registro por cada consulta médica
- **Sistema de Permisos**: Control de acceso entre médicos
- **Auditoría**: Registro completo de accesos y modificaciones

**Sistema de permisos:**
- El médico propietario tiene acceso total
- Otros médicos solicitan acceso al paciente
- El paciente aprueba/rechaza solicitudes
- Auditoría de todos los accesos

### 3️⃣ Órdenes Médicas

**Tipos de órdenes:**
- 💊 **Recetas**: Medicamentos con dosis, frecuencia y duración
- 🔬 **Laboratorio**: Exámenes clínicos (sangre, orina, etc.)
- 📷 **Imagenología**: Rayos X, tomografías, resonancias
- 🏥 **Referencias**: Interconsultas a otras especialidades
- 📋 **Mixtas**: Combinación de varios tipos

### 4️⃣ Sistema de Facturación

**Características:**
- Multi-moneda: Bolívares (Bs) y Dólares (USD)
- Tasa de cambio actualizable
- Sistema de reparto automático:
  - % para el médico
  - % para el consultorio
  - % para administración
- Liquidaciones por médico
- Reportes de ingresos

### 5️⃣ Sistema de Notificaciones

**Canales:**
- 📧 **Email**: Confirmaciones, recordatorios, alertas
- 🔔 **Notificaciones en tiempo real**: WebSockets
- 💾 **Notificaciones en base de datos**: Historial persistente

**Eventos notificados:**
- Confirmación de cita
- Cambio de estado de cita
- Solicitud de acceso a historia clínica
- Cambio de contraseña
- Nuevo inicio de sesión desde dispositivo desconocido
- Bloqueo de cuenta por seguridad

---

## 🛡️ Seguridad

### Características de Seguridad Implementadas

- ✅ **Autenticación robusta**: Sistema de login con validación de estado
- ✅ **Protección CSRF**: En todos los formularios
- ✅ **Preguntas de seguridad**: Para recuperación de contraseña
- ✅ **Validación de dispositivos**: Detección de nuevos dispositivos
- ✅ **Bloqueo automático**: Tras intentos fallidos de login
- ✅ **Historial de contraseñas**: Previene reutilización de contraseñas
- ✅ **Auditoría completa**: Registro de acciones críticas

### ⚠️ Recomendaciones de Seguridad para Producción

> **IMPORTANTE**: Antes de desplegar en producción, implementar las siguientes mejoras:

1. **Cambiar sistema de hash de contraseñas**
   - Actualmente usa MD5 (INSEGURO)
   - Migrar a bcrypt o argon2

2. **Configurar variables de entorno**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   DB_PASSWORD=contraseña_segura
   ```

3. **Configurar HTTPS**
   - Certificado SSL/TLS válido
   - Redirigir HTTP a HTTPS

4. **Rate Limiting**
   - Implementar límites en APIs públicas
   - Protección contra fuerza bruta

5. **Validación de archivos**
   - Validar tipos MIME
   - Limitar tamaño de uploads

---

## 🔌 API REST

El sistema incluye soporte para API REST (actualmente deshabilitado).

### Habilitar API

1. Descomentar rutas en `routes/api.php`
2. Configurar Sanctum en `.env`
3. Ejecutar migraciones de tokens

### Endpoints Disponibles

```
POST   /api/login              # Autenticación
POST   /api/register           # Registro de usuario
GET    /api/citas              # Listar citas
POST   /api/citas              # Crear cita
GET    /api/citas/{id}         # Detalle de cita
PUT    /api/citas/{id}         # Actualizar cita
DELETE /api/citas/{id}         # Cancelar cita
```

---

## 📊 Base de Datos

### Tablas Principales

- `usuarios` - Credenciales de acceso
- `administradores` - Perfiles de administradores
- `medicos` - Perfiles de médicos
- `pacientes` - Perfiles de pacientes
- `citas` - Citas médicas
- `consultorios` - Instalaciones físicas
- `especialidades` - Especialidades médicas
- `historia_clinica_base` - Historia base del paciente
- `evolucion_clinica` - Evoluciones por cita
- `ordenes_medicas` - Órdenes médicas
- `facturas_pacientes` - Facturación
- `pagos` - Registro de pagos

### Diagrama de Relaciones

```
Usuario (1) ─────── (0..1) Administrador
        │
        ├────────── (0..1) Medico ──── (N) Especialidad
        │                   │
        │                   └─── (N) Consultorio
        │
        └────────── (0..1) Paciente ─── (N) Cita
                                │           │
                                │           └── (N) EvolucionClinica
                                │
                                └── (1) HistoriaClinicaBase
```

---

## 🧪 Testing

### Ejecutar Tests

```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test --filter CitaTest

# Con coverage
php artisan test --coverage
```

---

## 📖 Comandos Artisan Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimizar aplicación
php artisan optimize

# Generar backup de base de datos
php artisan backup:run

# Ver rutas disponibles
php artisan route:list

# Ver trabajos en cola
php artisan queue:work

# Iniciar WebSockets
php artisan reverb:start
```

---

## 🔧 Configuración Adicional

### Configuración de Email (SMTP)

Editar `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_contraseña_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reservamedica.com
MAIL_FROM_NAME="ReservaMedica"
```

### Configuración de WebSockets (Laravel Reverb)

```env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=tu_app_id
REVERB_APP_KEY=tu_app_key
REVERB_APP_SECRET=tu_app_secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

---

## 📝 Desarrollo

### Estándares de Código

- **PSR-12** para código PHP
- **Convenciones de Laravel** para estructura
- **Nombres descriptivos** en español para el dominio
- **Comentarios** para lógica compleja

### Contribuir

1. Fork el proyecto
2. Crear rama de feature (`git checkout -b feature/NuevaFuncionalidad`)
3. Commit cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/NuevaFuncionalidad`)
5. Crear Pull Request

---

## 📄 Documentación Adicional

- [ANALISIS_DESCRIPTIVO_PROYECTO.md](ANALISIS_DESCRIPTIVO_PROYECTO.md) - Análisis técnico completo
- [SEEDERS_INSTRUCCIONES.md](SEEDERS_INSTRUCCIONES.md) - Guía de seeders
- [ARQUITECTURA_PACIENTE_HALLAZGOS.md](ARQUITECTURA_PACIENTE_HALLAZGOS.md) - Hallazgos arquitectónicos

---

## 🐛 Solución de Problemas

### Error: "Undefined variable $urlRecuperacion"
**Solución**: Verificar que `AuthController.php` esté actualizado con la variable correcta

### Error: "Class not found"
**Solución**: Ejecutar `composer dump-autoload`

### Error: "SQLSTATE[HY000] [2002] Connection refused"
**Solución**: Verificar que MySQL esté ejecutándose y las credenciales en `.env` sean correctas

### Assets no se cargan
**Solución**: Ejecutar `npm run build` o `npm run dev`

---

## 📞 Soporte

Para reportar bugs o solicitar nuevas funcionalidades, crear un issue en GitHub.

---

## 📜 Licencia

Este proyecto es de código privado y está protegido bajo derechos de autor.

---

## 👨‍💻 Desarrolladores

- **Equipo de Desarrollo ReservaMedica**
- Framework: Laravel 10
- Año: 2026

---

<p align="center">
  Hecho con ❤️ usando Laravel
</p>
