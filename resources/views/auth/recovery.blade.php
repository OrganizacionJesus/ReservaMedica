@extends('layouts.auth')

@section('title', 'Recuperar Contraseña')

@section('auth-content')
<!-- Modern Modal Component (Vanilla JS) -->
<div id="recoveryModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <!-- Background overlay with glassmorphism -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div onclick="closeRecoveryModal()" class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <!-- Modal Panel -->
        <div class="inline-block align-bottom rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px);">
            
            <!-- Modal Content -->
            <div class="px-6 pt-5 pb-4 sm:p-6">
                <!-- Icon -->
                <div class="flex items-center justify-center mb-4">
                    <div id="modalIcon" class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg transform transition-all duration-300 hover:scale-110">
                        <i id="modalIconClass" class="text-3xl"></i>
                    </div>
                </div>

                <!-- Title -->
                <h3 id="modalTitle" class="text-xl font-bold text-center text-slate-900 mb-2"></h3>
                
                <!-- Message -->
                <p id="modalMessage" class="text-sm text-center text-slate-600 mb-6"></p>

                <!-- Action Button -->
                <div class="flex justify-center">
                    <button onclick="closeRecoveryModal()" 
                            id="modalButton"
                            class="px-8 py-3 rounded-xl text-white font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-opacity-50">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Header Icon -->
<div class="flex justify-center mb-6">
    <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-300">
        <i class="bi bi-key-fill text-3xl"></i>
    </div>
</div>

<!-- Title & Description -->
<div class="text-center mb-8">
    <h2 class="text-3xl font-display font-bold text-slate-900 tracking-tight">
        Recuperar Contraseña
    </h2>
    <p class="mt-2 text-sm text-slate-500">
        Elige cómo deseas recuperar tu cuenta
    </p>
</div>

<!-- Method Selection (Step 0) -->
<div id="methodSelection" class="space-y-4">
    <p class="text-sm text-slate-600 text-center mb-6">
        Selecciona el método de recuperación que prefieras:
    </p>

    <!-- Email Option -->
    <button 
        onclick="selectMethod('email')"
        type="button"
        class="w-full group relative flex items-center p-5 border-2 border-slate-200 rounded-xl hover:border-medical-500 hover:bg-medical-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-medical-500/20"
    >
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-lg bg-medical-100 text-medical-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-envelope-fill text-2xl"></i>
            </div>
        </div>
        <div class="ml-4 flex-1 text-left">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-medical-600 transition-colors">
                Recuperar por Email
            </h3>
            <p class="text-xs text-slate-500 mt-1">
                Recibirás un enlace de recuperación en tu correo
            </p>
        </div>
        <i class="bi bi-arrow-right text-slate-400 group-hover:text-medical-600 group-hover:translate-x-1 transition-all"></i>
    </button>

    <!-- Security Questions Option -->
    <button 
        onclick="selectMethod('questions')"
        type="button"
        class="w-full group relative flex items-center p-5 border-2 border-slate-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
    >
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-shield-lock-fill text-2xl"></i>
            </div>
        </div>
        <div class="ml-4 flex-1 text-left">
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                Preguntas de Seguridad
            </h3>
            <p class="text-xs text-slate-500 mt-1">
                Responde tus preguntas de seguridad
            </p>
        </div>
        <i class="bi bi-arrow-right text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
    </button>

    <!-- Back to Login -->
    <div class="text-center pt-4">
        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center justify-center gap-1 group">
            <i class="bi bi-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Volver al inicio de sesión
        </a>
    </div>
</div>

<!-- Email Recovery Method -->
<div id="emailMethod" class="hidden space-y-6 animate-fade-in">
    <div class="bg-medical-50 border-l-4 border-medical-500 p-4 rounded-lg mb-6">
        <div class="flex items-start">
            <i class="bi bi-info-circle-fill text-medical-500 mt-0.5"></i>
            <div class="ml-3">
                <p class="text-sm text-medical-800">
                    Te enviaremos un enlace de recuperación a tu correo electrónico registrado.
                </p>
            </div>
        </div>
    </div>

    <form id="emailRecoveryForm" class="space-y-5">
        @csrf
        <div>
            <label for="email_recovery" class="block text-sm font-semibold text-slate-700 mb-2">
                Correo Electrónico
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="bi bi-envelope text-slate-400"></i>
                </div>
                <input 
                    type="email" 
                    id="email_recovery" 
                    name="email" 
                    class="block w-full pl-11 pr-4 py-3.5 text-sm border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition-all"
                    placeholder="tu@email.com" 
                    required
                >
            </div>
        </div>

        <button type="submit" id="emailRecoveryBtn" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-medical-600 to-blue-600 hover:from-medical-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-medical-500 transform hover:scale-[1.02] transition-all duration-200">
            <i class="bi bi-send-fill mr-2"></i>
            Enviar Enlace de Recuperación
        </button>

        <button type="button" onclick="backToSelection()" class="w-full text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center justify-center gap-1">
            <i class="bi bi-arrow-left"></i>
            Elegir otro método
        </button>
    </form>
</div>

<!-- Questions Recovery Method --> 
<div id="questionsMethod" class="hidden animate-fade-in">
    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex flex-col items-center flex-1">
                <div id="step1-indicator" class="w-10 h-10 flex items-center justify-center rounded-full bg-medical-600 text-white font-bold text-sm transition-all shadow-lg">
                    1
                </div>
                <div class="mt-2 text-xs font-medium text-medical-600">Identificación</div>
            </div>
            
            <div class="flex-1 h-1 bg-gray-200 transition-colors mx-2" id="progress-line"></div>
            
            <div class="flex flex-col items-center flex-1">
                <div id="step2-indicator" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-500 font-bold text-sm transition-all">
                    2
                </div>
                <div class="mt-2 text-xs font-medium text-gray-500" id="step2-text">Verificación</div>
            </div>
        </div>
    </div>

    <!-- Step 1: Identification -->
    <div id="step1" class="transition-opacity duration-300 space-y-6">
        <form id="identificationForm" class="space-y-5">
            @csrf
            
            <div>
                <label for="identifier" class="block text-sm font-semibold text-slate-700 mb-2">
                    Correo Electrónico o Cédula
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-person-circle text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        id="identifier" 
                        name="identifier" 
                        class="block w-full pl-11 pr-4 py-3.5 text-sm border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition-all"
                        placeholder="tu@email.com o V-12345678" 
                        required
                        autofocus
                    >
                </div>
                <p class="mt-2 text-xs text-slate-500">
                    Ingresa el dato asociado a tu cuenta
                </p>
            </div>

            <button type="submit" id="verifyBtn" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-[1.02] transition-all duration-200">
                <i class="bi bi-search mr-2"></i>
                Buscar Cuenta
            </button>

            <button type="button" onclick="backToSelection()" class="w-full text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center justify-center gap-1">
                <i class="bi bi-arrow-left"></i>
                Elegir otro método
            </button>
        </form>
    </div>

    <!-- Step 2: Security Questions -->
    <div id="step2" class="hidden transition-opacity duration-300 space-y-6">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6">
            <div class="flex items-start">
                <i class="bi bi-exclamation-triangle-fill text-yellow-400 mt-0.5"></i>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-yellow-800">Verificación de Seguridad</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        Responde las 3 preguntas. Tienes <span id="attempts-left" class="font-bold">3</span> intentos.
                    </p>
                </div>
            </div>
        </div>

        <form id="securityForm" class="space-y-5">
            @csrf
            <input type="hidden" name="user_id" id="user_id">
            
            <div id="security-questions-container" class="space-y-5">
                <!-- Questions loaded dynamically -->
            </div>

            <button type="submit" id="verifyQuestionsBtn" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-[1.02] transition-all duration-200">
                <i class="bi bi-shield-check mr-2"></i>
                Verificar Respuestas
            </button>

            <button type="button" onclick="location.reload()" class="w-full text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center justify-center gap-1">
                <i class="bi bi-arrow-left"></i>
                Intentar con otra cuenta
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endpush

@push('scripts')
<script>
// Vanilla JS Modal Functions
window.showRecoveryModal = function(type, title, message) {
    console.log('[Modal] Showing modal:', { type, title, message });
    
    const modal = document.getElementById('recoveryModal');
    const modalIcon = document.getElementById('modalIcon');
    const modalIconClass = document.getElementById('modalIconClass');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalButton = document.getElementById('modalButton');
    
    // Set content
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    
    // Reset classes
    modalIcon.className = 'w-16 h-16 rounded-full flex items-center justify-center shadow-lg transform transition-all duration-300 hover:scale-110';
    modalIconClass.className = 'text-3xl';
    modalButton.className = 'px-8 py-3 rounded-xl text-white font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-opacity-50';
    
    // Apply type-specific styles
    if (type === 'success') {
        modalIcon.classList.add('bg-green-100', 'text-green-600');
        modalIconClass.classList.add('bi-check-circle-fill');
        modalButton.classList.add('bg-gradient-to-r', 'from-green-600', 'to-emerald-600', 'hover:from-green-700', 'hover:to-emerald-700');
    } else if (type === 'error') {
        modalIcon.classList.add('bg-red-100', 'text-red-600');
        modalIconClass.classList.add('bi-x-circle-fill');
        modalButton.classList.add('bg-gradient-to-r', 'from-red-600', 'to-rose-600', 'hover:from-red-700', 'hover:to-rose-700');
    } else if (type === 'warning') {
        modalIcon.classList.add('bg-yellow-100', 'text-yellow-600');
        modalIconClass.classList.add('bi-exclamation-triangle-fill');
        modalButton.classList.add('bg-gradient-to-r', 'from-yellow-600', 'to-amber-600', 'hover:from-yellow-700', 'hover:to-amber-700');
    }
    
    // Show modal with animation
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
    }, 10);
};

window.closeRecoveryModal = function() {
    const modal = document.getElementById('recoveryModal');
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
};

// Global functions
function selectMethod(method) {
    document.getElementById('methodSelection').classList.add('hidden');
    
    if (method === 'email') {
        document.getElementById('emailMethod').classList.remove('hidden');
    } else if (method === 'questions') {
        document.getElementById('questionsMethod').classList.remove('hidden');
    }
}

function backToSelection() {
    document.getElementById('methodSelection').classList.remove('hidden');
    document.getElementById('emailMethod').classList.add('hidden');
    document.getElementById('questionsMethod').classList.add('hidden');
    
    // Reset questions method
    document.getElementById('step1').classList.remove('hidden');
    document.getElementById('step2').classList.add('hidden');
}

let attemptsRemaining = 3;
let securityQuestions = [];
let userId = null;

// ===== EMAIL RECOVERY =====
const emailRecoveryForm = document.getElementById('emailRecoveryForm');
const emailRecoveryBtn = document.getElementById('emailRecoveryBtn');

console.log('[Recovery] Email form:', emailRecoveryForm ? 'FOUND' : 'NOT FOUND');

if(emailRecoveryForm) {
    emailRecoveryForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('[Recovery] Email form submitted');
        
        const email = document.getElementById('email_recovery').value.trim();
        
        // Simple email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showRecoveryModal('error', 'Correo Inválido', 'Por favor ingresa un correo electrónico válido.');
            return;
        }
        
        // Disable button
        if (emailRecoveryBtn) {
            emailRecoveryBtn.disabled = true;
            emailRecoveryBtn.innerHTML = '<i class="bi bi-hourglass-split animate-spin mr-2"></i> Enviando...';
        }
        
        try {
            const response = await fetch("{{ route('recovery.send-email') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                },
                body: JSON.stringify({ email })
            });
            
            const text = await response.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.warn('Response was not JSON:', text);
                throw new Error('La respuesta del servidor no es válida.');
            }
            
            if (emailRecoveryBtn) {
                emailRecoveryBtn.disabled = false;
                emailRecoveryBtn.innerHTML = '<i class="bi bi-send-fill mr-2"></i> Enviar Enlace de Recuperación';
            }
            
            if (data.success) {
                showRecoveryModal('success', '¡Enlace Enviado!', 'Revisa tu correo electrónico para continuar con la recuperación.');
                setTimeout(() => window.location.href = '{{ route('login') }}', 3000);
            } else {
                showRecoveryModal('error', 'Correo No Encontrado', data.message || 'El correo ingresado no está registrado en el sistema.');
            }
        } catch (error) {
            if (emailRecoveryBtn) {
                emailRecoveryBtn.disabled = false;
                emailRecoveryBtn.innerHTML = '<i class="bi bi-send-fill mr-2"></i> Enviar Enlace de Recuperación';
            }
            console.error('Error detallado:', error);
            showRecoveryModal('error', 'Error de Conexión', error.message || 'No se pudo conectar con el servidor. Verifica tu conexión e intenta nuevamente.');
        }
    });
}

// ===== SECURITY QUESTIONS RECOVERY =====
const identificationForm = document.getElementById('identificationForm');
const verifyBtn = document.getElementById('verifyBtn');

console.log('[Recovery] Script loaded - identificationForm:', identificationForm ? 'FOUND' : 'NOT FOUND');
console.log('[Recovery] verifyBtn:', verifyBtn ? 'FOUND' : 'NOT FOUND');

if(identificationForm) {
    console.log('[Recovery] Attaching submit event listener...');
    
    identificationForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('[Recovery] Form submitted! Event prevented.');
        
        const identifier = document.getElementById('identifier').value.trim();
        console.log('[Recovery] Identifier:', identifier);
        
        if (!identifier) {
            showRecoveryModal('warning', 'Campo Requerido', 'Por favor ingresa tu correo electrónico o cédula.');
            return;
        }
        
        // Disable button
        if (verifyBtn) {
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="bi bi-hourglass-split animate-spin mr-2"></i> Buscando...';
        }
        
        // Get CSRF token from meta tag or form input
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                       || document.querySelector('[name="_token"]')?.value;
        
        console.log('[Recovery] CSRF Token:', csrfToken ? 'Found' : 'Missing');
        
        if (!csrfToken) {

            showRecoveryModal('error', 'Error de Seguridad', 'Token de seguridad no encontrado. Por favor recarga la página e intenta nuevamente.');
            if (verifyBtn) {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<i class="bi bi-search mr-2"></i> Buscar Cuenta';
            }
            return;
        }
        
        try {
            console.log('[Recovery] Sending fetch request...');
            const response = await fetch("{{ route('recovery.get-questions') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ identifier })
            });
            
            console.log('[Recovery] Response status:', response.status);
            console.log('[Recovery] Response OK:', response.ok);
            
            // Check if response is JSON
            const contentType = response.headers.get("content-type");
            console.log('[Recovery] Content-Type:', contentType);
            
            if (!contentType || !contentType.includes("application/json")) {
                const textResponse = await response.text();
                console.error('[Recovery] Response is NOT JSON:', textResponse);
    
                showRecoveryModal('error', 'Error del Servidor', 'La respuesta del servidor no es válida. Intenta nuevamente.');
                if (verifyBtn) {
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = '<i class="bi bi-search mr-2"></i> Buscar Cuenta';
                }
                return;
            }
            
            const data = await response.json();
            console.log('[Recovery] Response data:', data);
            
            if (data.success) {
                console.log('[Recovery] SUCCESS! Questions found:', data.questions?.length || 0);
                
                if (!data.questions || data.questions.length === 0) {
        
                    showRecoveryModal('warning', 'Sin Preguntas de Seguridad', 'Este usuario no tiene preguntas de seguridad configuradas. Intenta recuperar tu cuenta por email.');
                    if (verifyBtn) {
                        verifyBtn.disabled = false;
                        verifyBtn.innerHTML = '<i class="bi bi-search mr-2"></i> Buscar Cuenta';
                    }
                    return;
                }
                
                securityQuestions = data.questions;
                userId = data.user_id;
                showStep2(data.questions, data.user_id);
            } else {
                console.error('[Recovery] Request FAILED:', data.message);
                const errorMsg = data.message || 'Usuario no encontrado o sin preguntas configuradas';
    
                showRecoveryModal('error', 'Usuario No Encontrado', errorMsg);
                if (verifyBtn) {
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = '<i class="bi bi-search mr-2"></i> Buscar Cuenta';
                }
            }
            
        } catch (error) {
            console.error('[Recovery] FATAL ERROR:', error);
            console.error('[Recovery] Error message:', error.message);
            console.error('[Recovery] Error stack:', error.stack);
            

            showRecoveryModal('error', 'Error de Conexión', 'No se pudo conectar con el servidor. Verifica tu conexión e intenta nuevamente.');
            
            if (verifyBtn) {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<i class="bi bi-search mr-2"></i> Buscar Cuenta';
            }
        }
    });
    
    console.log('[Recovery] Event listener attached successfully!');
} else {
    console.error('[Recovery] ERROR: identificationForm not found in DOM!');
}

function showStep2(questions, user_id) {
    document.getElementById('step1').classList.add('hidden');
    
    // Update indicators
    const step1Ind = document.getElementById('step1-indicator');
    step1Ind.classList.remove('bg-medical-600');
    step1Ind.classList.add('bg-green-500');
    step1Ind.innerHTML = '<i class="bi bi-check"></i>';
    
    document.getElementById('progress-line').classList.remove('bg-gray-200');
    document.getElementById('progress-line').classList.add('bg-medical-600');
    
    const step2Ind = document.getElementById('step2-indicator');
    document.getElementById('step2-text').classList.remove('text-gray-500');
    document.getElementById('step2-text').classList.add('text-medical-600');
    step2Ind.classList.remove('bg-gray-200', 'text-gray-500');
    step2Ind.classList.add('bg-medical-600', 'text-white', 'shadow-lg');
    
    // Render questions
    const container = document.getElementById('security-questions-container');
    container.innerHTML = '';
    
    questions.forEach((q, index) => {
        container.innerHTML += `
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pregunta ${index + 1}: ${q.pregunta}
                </label>
                <input type="hidden" name="question_${index + 1}_id" value="${q.id}">
                <input 
                    type="text" 
                    name="answer_${index + 1}" 
                    class="block w-full px-4 py-3.5 text-sm border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition-all" 
                    placeholder="Tu respuesta" 
                    required
                    autocomplete="off"
                >
            </div>
        `;
    });
    
    document.getElementById('user_id').value = user_id;
    document.getElementById('step2').classList.remove('hidden');
}

const securityForm = document.getElementById('securityForm');
const verifyQuestionsBtn = document.getElementById('verifyQuestionsBtn');

if (securityForm) {
    securityForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (attemptsRemaining <= 0) {

            showRecoveryModal('error', 'Intentos Agotados', 'Has agotado tus intentos. Tu cuenta ha sido bloqueada por seguridad.');
            return;
        }
        
        const formData = new FormData(this);
        
        // Disable button
        if (verifyQuestionsBtn) {
            verifyQuestionsBtn.disabled = true;
            verifyQuestionsBtn.innerHTML = '<i class="bi bi-hourglass-split animate-spin mr-2"></i> Verificando...';
        }
        
        try {
            const response = await fetch("{{ route('recovery.verify-answers') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (verifyQuestionsBtn) {
                verifyQuestionsBtn.disabled = false;
                verifyQuestionsBtn.innerHTML = '<i class="bi bi-shield-check mr-2"></i> Verificar Respuestas';
            }
            
            if (data.success) {
    
                showRecoveryModal('success', '¡Respuestas Correctas!', 'Verificación exitosa. Redirigiendo al cambio de contraseña...');
                setTimeout(() => {
                    if(data.token && data.email) {
                        window.location.href = "{{ url('/reset-password') }}/" + data.token + "?email=" + data.email;
                    }
                }, 2000);
            } else if (data.locked) {
                // Account has been locked
                handleAccountLocked(data);
            } else {
                // Wrong answers, but not locked yet
                handleFailure(data);
            }
            
        } catch (error) {
            console.error('Error in security questions verification:', error);
            if (verifyQuestionsBtn) {
                verifyQuestionsBtn.disabled = false;
                verifyQuestionsBtn.innerHTML = '<i class="bi bi-shield-check mr-2"></i> Verificar Respuestas';
            }

            showRecoveryModal('error', 'Error de Verificación', 'No se pudieron verificar las respuestas. Intenta nuevamente.');
        }
    });
}

function handleAccountLocked(data) {
    const blockedUntil = data.blocked_until || '24 horas';
    

    showRecoveryModal('error', 'Cuenta Bloqueada', `Tu cuenta ha sido bloqueada por seguridad hasta ${blockedUntil} debido a múltiples intentos fallidos.`);
    
    // Disable form
    if (verifyQuestionsBtn) {
        verifyQuestionsBtn.disabled = true;
        verifyQuestionsBtn.innerHTML = '<i class="bi bi-lock-fill mr-2"></i>Cuenta Bloqueada';
        verifyQuestionsBtn.classList.remove('bg-gradient-to-r', 'from-green-600', 'to-emerald-600');
        verifyQuestionsBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
    }
    
    // Show lockout message
    const lockoutMsg = document.createElement('div');
    lockoutMsg.className = 'bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mt-4';
    lockoutMsg.innerHTML = `
        <div class="flex items-start">
            <i class="bi bi-exclamation-triangle-fill text-red-500 mt-0.5 text-xl"></i>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-red-800">Cuenta Bloqueada Temporalmente</h3>
                <p class="text-sm text-red-700 mt-1">
                    Tu cuenta ha sido bloqueada hasta <strong>${blockedUntil}</strong> por seguridad debido a múltiples intentos fallidos.
                </p>
                <p class="text-xs text-red-600 mt-2">
                    Recibirás un correo electrónico con más información.
                </p>
            </div>
        </div>
    `;
    securityForm.appendChild(lockoutMsg);
    
    attemptsRemaining = 0;
}

function handleFailure(data) {
    // Update attempts from server response if provided
    if (data.attempts_remaining !== undefined) {
        attemptsRemaining = data.attempts_remaining;
        document.getElementById('attempts-left').textContent = attemptsRemaining;
    } else {
        attemptsRemaining--;
        document.getElementById('attempts-left').textContent = attemptsRemaining;
    }
    
    if (attemptsRemaining > 0) {

        showRecoveryModal('warning', 'Respuestas Incorrectas', `Las respuestas no son correctas. Te quedan ${attemptsRemaining} ${attemptsRemaining === 1 ? 'intento' : 'intentos'}.`);
        document.querySelectorAll('[name^="answer_"]').forEach(i => {
           i.value = '';
           i.classList.add('border-red-300');
           setTimeout(() => i.classList.remove('border-red-300'), 3000);
        });
    } else {

        showRecoveryModal('error', 'Cuenta Bloqueada', 'Tu cuenta ha sido bloqueada temporalmente por seguridad debido a múltiples intentos fallidos.');
        if (verifyQuestionsBtn) {
            verifyQuestionsBtn.disabled = true;
        }
    }
}
</script>
@endpush
@endsection
