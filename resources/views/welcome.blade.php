<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistema Médico') }} - Reservas Médicas Profesionales</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #0e7490 100%);
            position: relative;
            overflow: hidden;
        }
        
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(14, 116, 144, 0.3) 0%, transparent 50%);
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #0e7490 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.4);
        }
        
        .portal-card {
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
        }
        
        .portal-card:hover {
            border-color: #3b82f6;
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(59, 130, 246, 0.2);
        }
        
        .icon-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .fade-in-delay-1 { animation-delay: 0.1s; }
        .fade-in-delay-2 { animation-delay: 0.2s; }
        .fade-in-delay-3 { animation-delay: 0.3s; }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .feature-step {
            position: relative;
            padding-left: 2.5rem;
        }
        
        .feature-step::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 2.5rem;
            bottom: -2rem;
            width: 2px;
            background: linear-gradient(180deg, #3b82f6 0%, transparent 100%);
        }
        
        .feature-step:last-child::before {
            display: none;
        }
        
        .step-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-700">
    
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 navbar-glass" id="navbar">
        <div class="container mx-auto px-4 sm:px-6 h-16 flex justify-between items-center">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center shadow-lg group-hover:shadow-blue-500/50 transition-shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="leading-tight hidden sm:block">
                    <div class="font-bold text-base text-slate-900 tracking-tight">{{ config('app.name', 'SisMed') }}</div>
                    <div class="text-xs font-semibold text-slate-500">Reservas Médicas</div>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-4">
                <a href="#portales" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors px-3 py-2 rounded-lg hover:bg-slate-100">Portales</a>
                <a href="#como-funciona" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors px-3 py-2 rounded-lg hover:bg-slate-100">¿Cómo funciona?</a>
                <div class="h-6 w-px bg-slate-300"></div>
                <a href="{{ route('login', ['rol' => 'paciente']) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl border-2 border-slate-300 text-sm font-semibold text-slate-700 hover:border-blue-600 hover:text-blue-600 transition-all">Ingresar</a>
                <a href="{{ route('register', ['rol' => 'paciente']) }}" class="btn-primary inline-flex items-center justify-center h-10 px-5 rounded-xl text-sm font-semibold text-white relative">
                    Crear cuenta
                </a>
            </div>

            <!-- Mobile Menu -->
            <div class="flex items-center gap-2 md:hidden">
                <a href="{{ route('login', ['rol' => 'paciente']) }}" class="inline-flex items-center justify-center h-9 px-3 rounded-lg border-2 border-slate-300 text-sm font-semibold text-slate-700">Ingresar</a>
                <a href="{{ route('register', ['rol' => 'paciente']) }}" class="btn-primary inline-flex items-center justify-center h-9 px-4 rounded-lg text-sm font-semibold text-white relative">Registrarse</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg relative">
        <div class="container mx-auto px-4 sm:px-6 py-16 sm:py-20 lg:py-24 relative z-10">
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left text-white fade-in">
                    <div class="inline-block px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 mb-4">
                        <p class="text-xs font-bold text-white uppercase tracking-wider">Sistema de Reservas Médicas</p>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-4">
                        Tu salud,<br/>
                        <span class="bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">más accesible</span>
                    </h1>
                    <p class="text-base sm:text-lg text-blue-100 leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
                        Agenda citas médicas en segundos. Portal simple para pacientes, panel profesional para médicos y administración.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start mb-12 fade-in fade-in-delay-1">
                        <a href="{{ route('register', ['rol' => 'paciente']) }}" class="inline-flex items-center justify-center h-14 px-8 rounded-xl bg-white text-blue-600 text-base font-bold hover:bg-blue-50 transition-all hover:scale-105 shadow-xl hover:shadow-2xl">
                            Crear cuenta gratis
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login', ['rol' => 'paciente']) }}" class="inline-flex items-center justify-center h-14 px-8 rounded-xl border-2 border-white text-white text-base font-bold hover:bg-white/10 transition-all backdrop-blur-sm">
                            Ya tengo cuenta
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0 fade-in fade-in-delay-2">
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-black text-white">3</div>
                            <div class="text-xs sm:text-sm text-blue-200 font-semibold mt-1">Portales</div>
                        </div>
                        <div class="text-center border-l border-r border-white/30">
                            <div class="text-2xl sm:text-3xl font-black text-white">24/7</div>
                            <div class="text-xs sm:text-sm text-blue-200 font-semibold mt-1">Acceso</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-black text-white">100%</div>
                            <div class="text-xs sm:text-sm text-blue-200 font-semibold mt-1">Seguro</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Access Card -->
                <div class="glass-card rounded-3xl p-6 sm:p-8 transition-all fade-in fade-in-delay-3">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Acceso Rápido</h3>
                        <div class="px-3 py-1 rounded-full bg-white/20 border border-white/30">
                            <p class="text-xs font-bold text-white">Selecciona tu rol</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-6">
                        <a href="{{ route('login', ['rol' => 'paciente']) }}" class="block rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 px-5 py-4 transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-500/30 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base font-bold text-white">Paciente</span>
                                </div>
                                <svg class="w-5 h-5 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('login', ['rol' => 'medico']) }}" class="block rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 px-5 py-4 transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-cyan-500/30 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base font-bold text-white">Médico</span>
                                </div>
                                <svg class="w-5 h-5 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('login', ['rol' => 'admin']) }}" class="block rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 px-5 py-4 transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-purple-500/30 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base font-bold text-white">Administrador</span>
                                </div>
                                <svg class="w-5 h-5 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div class="rounded-lg bg-white/10 border border-white/20 p-3 text-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs font-bold text-white">Citas</p>
                        </div>
                        <div class="rounded-lg bg-white/10 border border-white/20 p-3 text-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-xs font-bold text-white">Historial</p>
                        </div>
                        <div class="rounded-lg bg-white/10 border border-white/20 p-3 text-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-xs font-bold text-white">Pagos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portals Section -->
    <section id="portales" class="py-16 sm:py-20 bg-slate-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-block px-4 py-1.5 rounded-full bg-blue-100 border border-blue-200 mb-4">
                    <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">Portales Especializados</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">Diseñado para cada rol</h2>
                <p class="text-base text-slate-600 leading-relaxed">Cada usuario tiene un portal personalizado con las herramientas que necesita.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8 mb-16">
                <!-- Portal Paciente -->
                <div class="portal-card rounded-2xl p-6 sm:p-8 shadow-lg">
                    <div class="icon-circle mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Portal Paciente</h3>
                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                        Gestiona tus citas, accede a tu historial médico y recibe recordatorios automáticos. Todo en un solo lugar.
                    </p>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Agendar citas online</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Historial clínico digital</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Recordatorios automáticos</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login', ['rol' => 'paciente']) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">Ingresar →</a>
                        <a href="{{ route('register', ['rol' => 'paciente']) }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 transition-colors">Registrarme</a>
                    </div>
                </div>

                <!-- Portal Médico -->
                <div class="portal-card rounded-2xl p-6 sm:p-8 shadow-lg">
                    <div class="icon-circle mb-6" style="background: linear-gradient(135deg, #0e7490 0%, #0891b2 100%);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Portal Médico</h3>
                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                        Control total de tu agenda, historias clínicas y seguimiento de pacientes con herramientas profesionales.
                    </p>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Gestión de agenda</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Historias clínicas completas</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Panel de control avanzado</span>
                        </div>
                    </div>
                    <a href="{{ route('login', ['rol' => 'medico']) }}" class="text-sm font-bold text-cyan-600 hover:text-cyan-700 transition-colors">Ingresar →</a>
                </div>

                <!-- Portal Admin -->
                <div class="portal-card rounded-2xl p-6 sm:p-8 shadow-lg">
                    <div class="icon-circle mb-6" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Administración</h3>
                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                        Panel de control integral para gestión de usuarios, configuraciones y reportes completos del sistema.
                    </p>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Gestión de usuarios</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Reportes y estadísticas</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Configuración del sistema</span>
                        </div>
                    </div>
                    <a href="{{ route('login', ['rol' => 'admin']) }}" class="text-sm font-bold text-purple-600 hover:text-purple-700 transition-colors">Ingresar →</a>
                </div>
            </div>

            <!-- How it Works Section -->
            <div id="como-funciona" class="max-w-4xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3">¿Cómo funciona?</h2>
                    <p class="text-base text-slate-600">Agenda tu cita médica en 3 simples pasos</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="feature-step">
                        <div class="step-number">1</div>
                        <div class="stat-card rounded-xl p-6 h-full">
                            <h4 class="text-lg font-black text-slate-900 mb-2">Regístrate</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Crea tu cuenta con tus datos personales. Es rápido, seguro y completamente gratuito.</p>
                        </div>
                    </div>

                    <div class="feature-step">
                        <div class="step-number">2</div>
                        <div class="stat-card rounded-xl p-6 h-full">
                            <h4 class="text-lg font-black text-slate-900 mb-2">Agenda tu cita</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Selecciona especialidad, consultorio, médico y horario disponible según tu preferencia.</p>
                        </div>
                    </div>

                    <div class="feature-step">
                        <div class="step-number">3</div>
                        <div class="stat-card rounded-xl p-6 h-full">
                            <h4 class="text-lg font-black text-slate-900 mb-2">Confirma y asiste</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Recibe confirmación y recordatorios. Accede a tu comprobante desde tu portal personal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 py-8">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Brand -->
                <div class="flex items-center gap-2.5">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-white text-base">{{ config('app.name') }}</span>
                </div>
                
                <div class="text-slate-400 text-sm font-medium">
                    &copy; {{ date('Y') }} Sistema Médico Integral. Todos los derechos reservados.
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('login', ['rol' => 'paciente']) }}" class="inline-flex items-center justify-center h-10 px-5 rounded-lg border-2 border-slate-700 text-sm font-semibold text-slate-300 hover:border-blue-500 hover:text-white transition-all">Ingresar</a>
                    <a href="{{ route('register', ['rol' => 'paciente']) }}" class="btn-primary inline-flex items-center justify-center h-10 px-5 rounded-lg text-sm font-semibold text-white relative">Crear cuenta</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>