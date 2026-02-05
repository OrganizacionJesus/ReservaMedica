/**
 * Sistema de Alertas y Notificaciones
 * Toast notifications y modals para el Sistema Médico
 */

// Configuración
const TOAST_DURATION = 5000; // 5 segundos
const TOAST_POSITIONS = {
    'top-right': 'top-4 right-4',
    'top-left': 'top-4 left-4',
    'bottom-right': 'bottom-4 right-4',
    'bottom-left': 'bottom-4 left-4',
    'top-center': 'top-4 left-1/2 -translate-x-1/2'
};

// Crear contenedor de toasts si no existe
function getToastContainer(position = 'top-right') {
    let container = document.getElementById('toast-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = `fixed ${TOAST_POSITIONS[position]} z-50 flex flex-col gap-2 max-w-md pointer-events-none`; // pointer-events-none para no bloquear clicks por debajo
        document.body.appendChild(container);
    }

    return container;
}

// Iconos por tipo
const TOAST_ICONS = {
    success: 'bi-check-circle-fill',
    error: 'bi-x-circle-fill',
    warning: 'bi-exclamation-triangle-fill',
    info: 'bi-info-circle-fill'
};

// Colores por tipo (Premium Glassmorphism)
const TOAST_COLORS = {
    success: {
        wrapper: 'bg-gradient-to-r from-green-50/95 to-white/95 border-green-200/50 shadow-green-500/10',
        icon: 'text-green-600',
        text: 'text-green-800'
    },
    error: {
        wrapper: 'bg-gradient-to-r from-red-50/95 to-white/95 border-red-200/50 shadow-red-500/10',
        icon: 'text-red-600',
        text: 'text-red-800'
    },
    warning: {
        wrapper: 'bg-gradient-to-r from-yellow-50/95 to-white/95 border-yellow-200/50 shadow-yellow-500/10',
        icon: 'text-yellow-600',
        text: 'text-yellow-800'
    },
    info: {
        wrapper: 'bg-gradient-to-r from-blue-50/95 to-white/95 border-blue-200/50 shadow-blue-500/10',
        icon: 'text-blue-600',
        text: 'text-blue-800'
    }
};

/**
 * Mostrar Toast Notification
 */
export function showToast(type, message, duration = TOAST_DURATION, position = 'top-right') {
    const container = getToastContainer(position);
    const style = TOAST_COLORS[type] || TOAST_COLORS.info;
    const icon = TOAST_ICONS[type] || TOAST_ICONS.info;

    // Crear elemento toast con diseño Glassmorphism
    const toast = document.createElement('div');
    toast.className = `
        ${style.wrapper} backdrop-blur-md border rounded-2xl shadow-xl 
        p-4 flex items-start gap-3 transform transition-all duration-500 cubic-bezier(0.19, 1, 0.22, 1) 
        translate-x-10 opacity-0 pointer-events-auto min-w-[320px] max-w-sm
    `;

    toast.innerHTML = `
        <div class="flex-shrink-0 w-8 h-8 rounded-full ${style.icon} bg-white/50 flex items-center justify-center shadow-sm">
            <i class="bi ${icon} text-lg"></i>
        </div>
        <div class="flex-1 ${style.text} pt-0.5">
            <p class="font-bold text-sm">Notificación</p>
            <p class="font-medium text-sm leading-snug opacity-90">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" 
                class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-full hover:bg-slate-100/50">
            <i class="bi bi-x-gl text-sm"></i>
        </button>
    `;

    // Agregar al contenedor
    container.appendChild(toast);

    // Animar entrada suave
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-10', 'opacity-0');
    });

    // Auto-remover después de duración
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => toast.remove(), 500);
    }, duration);

    return toast;
}

/**
 * Mostrar Modal de Confirmación
 */
export function showAlert(title, message, type = 'alert', onConfirm = null, onCancel = null) {
    // Crear overlay
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300 opacity-0';

    // Determinar icono y color según tipo
    let iconClass = 'bi-exclamation-triangle text-yellow-500';
    let confirmBtnClass = 'bg-blue-600 hover:bg-blue-700 text-white';

    if (type === 'confirm') {
        iconClass = 'bi-question-circle text-blue-500';
        confirmBtnClass = 'bg-blue-600 hover:bg-blue-700 text-white';
    } else if (type === 'error') {
        iconClass = 'bi-x-circle text-red-500';
        confirmBtnClass = 'bg-red-600 hover:bg-red-700 text-white';
    } else if (type === 'success') {
        iconClass = 'bi-check-circle text-green-500';
        confirmBtnClass = 'bg-green-600 hover:bg-green-700 text-white';
    }

    // Crear modal
    const modal = document.createElement('div');
    modal.className = 'bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 transform transition-all scale-95 opacity-0';

    modal.innerHTML = `
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-4">
                <i class="bi ${iconClass} text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">${title}</h3>
            <p class="text-sm text-gray-500 mb-6">${message}</p>
            
            <div class="flex gap-3 justify-center">
                ${type === 'confirm' ? `
                    <button id="modalCancel" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-colors">
                        Cancelar
                    </button>
                ` : ''}
                <button id="modalConfirm" class="px-4 py-2 rounded-lg ${confirmBtnClass} font-medium text-sm transition-colors shadow-sm">
                    ${type === 'confirm' ? 'Confirmar' : 'Entendido'}
                </button>
            </div>
        </div>
    `;

    overlay.appendChild(modal);
    document.body.appendChild(overlay);

    // Animar entrada
    requestAnimationFrame(() => {
        overlay.classList.remove('opacity-0');
        modal.classList.remove('scale-95', 'opacity-0');
    });

    // Event listeners
    const confirmBtn = modal.querySelector('#modalConfirm');
    const cancelBtn = modal.querySelector('#modalCancel');

    const closeModal = () => {
        overlay.classList.add('opacity-0');
        modal.classList.add('scale-95', 'opacity-0');
        setTimeout(() => overlay.remove(), 200);
    };

    confirmBtn.addEventListener('click', () => {
        if (onConfirm) onConfirm();
        closeModal();
    });

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            if (onCancel) onCancel();
            closeModal();
        });
    }

    // Cerrar al hacer clic fuera
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            if (onCancel) onCancel();
            closeModal();
        }
    });

    return overlay;
}

/**
 * Mostrar Loading Toast
 */
export function showLoading(message = 'Cargando...') {
    const container = getToastContainer('top-center');

    const toast = document.createElement('div');
    toast.className = 'bg-white border border-gray-200 rounded-full shadow-xl px-6 py-3 flex items-center gap-3 animate-bounce-soft pointer-events-auto';

    toast.innerHTML = `
        <div class="animate-spin text-blue-600">
            <i class="bi bi-arrow-repeat text-xl"></i>
        </div>
        <p class="font-medium text-gray-700 text-sm">${message}</p>
    `;

    container.appendChild(toast);

    return {
        element: toast,
        close: () => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }
    };
}

/**
 * Animación de shake para errores
 */
export function shakeElement(element) {
    element.classList.add('animate-pulse'); // Tailwind doesn't have shake by default, using pulse or custom
    // If we want real shake we need custom CSS or style injection. 
    // Using transform based translation manually for a quick shake effect
    const originalTransform = element.style.transform;

    element.style.transition = 'transform 0.1s';
    element.style.transform = 'translateX(-5px)';

    setTimeout(() => {
        element.style.transform = 'translateX(5px)';
        setTimeout(() => {
            element.style.transform = 'translateX(-5px)';
            setTimeout(() => {
                element.style.transform = 'translateX(5px)';
                setTimeout(() => {
                    element.style.transform = originalTransform;
                }, 100);
            }, 100);
        }, 100);
    }, 100);
}

/**
 * Mostrar validación en formulario
 */
export function showFormErrors(form, errors) {
    // Limpiar errores anteriores
    form.querySelectorAll('.form-error').forEach(el => el.remove());
    form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'focus:ring-red-500'));

    // Mostrar nuevos errores
    Object.keys(errors).forEach(fieldName => {
        const input = form.querySelector(`[name="${fieldName}"]`);
        if (input) {
            input.classList.add('border-red-500', 'focus:ring-red-500');

            const errorElement = document.createElement('p');
            errorElement.className = 'form-error text-red-600 text-xs mt-1 flex items-center gap-1';
            errorElement.innerHTML = `<i class="bi bi-exclamation-circle-fill"></i> ${errors[fieldName]}`;

            if (input.parentElement.classList.contains('relative')) {
                input.parentElement.parentElement.appendChild(errorElement);
            } else {
                input.parentElement.appendChild(errorElement);
            }

            // Shake el input
            shakeElement(input);
        }
    });

    // Scroll al primer error
    const firstError = form.querySelector('.border-red-500');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
    }
}
