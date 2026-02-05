/**
 * Theme Manager - Sistema de Gestión de Temas Claro/Oscuro
 * ReservaMedica - 2026
 * 
 * Maneja la persistencia y aplicación de temas en toda la aplicación
 */

class ThemeManager {
    constructor() {
        this.storageKey = 'reservamedica-theme';
        this.currentTheme = this.getStoredTheme();
        this.init();
    }

    /**
     * Inicializa el tema según preferencias guardadas o del sistema
     */
    init() {
        // Aplicar tema guardado o detectar preferencia del sistema
        if (this.currentTheme === 'dark') {
            this.setDark(false); // false = no guardar de nuevo
        } else if (this.currentTheme === 'light') {
            this.setLight(false);
        } else {
            // Auto-detectar preferencia del sistema
            this.detectSystemPreference();
        }

        // Escuchar cambios en preferencia del sistema
        this.listenSystemPreferenceChanges();
    }

    /**
     * Obtiene el tema guardado en localStorage
     */
    getStoredTheme() {
        return localStorage.getItem(this.storageKey);
    }

    /**
     * Detecta la preferencia del sistema operativo
     */
    detectSystemPreference() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.setDark();
        } else {
            this.setLight();
        }
    }

    /**
     * Escucha cambios en la preferencia del sistema
     */
    listenSystemPreferenceChanges() {
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!this.getStoredTheme()) { // Solo si no hay preferencia manual
                    if (e.matches) {
                        this.setDark();
                    } else {
                        this.setLight();
                    }
                }
            });
        }
    }

    /**
     * Alterna entre tema claro y oscuro
     */
    toggle() {
        if (this.currentTheme === 'dark') {
            this.setLight();
        } else {
            this.setDark();
        }

        // Disparar evento personalizado para que componentes puedan reaccionar
        this.dispatchThemeChangeEvent();
    }

    /**
     * Establece el tema oscuro
     * @param {boolean} save - Si se debe guardar en localStorage (default: true)
     */
    setDark(save = true) {
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-theme', 'dark');
        this.currentTheme = 'dark';

        if (save) {
            localStorage.setItem(this.storageKey, 'dark');
        }

        // Actualizar meta theme-color para barras del navegador móvil
        this.updateMetaThemeColor('#0f172a');
    }

    /**
     * Establece el tema claro
     * @param {boolean} save - Si se debe guardar en localStorage (default: true)
     */
    setLight(save = true) {
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-theme', 'light');
        this.currentTheme = 'light';

        if (save) {
            localStorage.setItem(this.storageKey, 'light');
        }

        // Actualizar meta theme-color para barras del navegador móvil
        this.updateMetaThemeColor('#ffffff');
    }

    /**
     * Actualiza el meta tag theme-color
     */
    updateMetaThemeColor(color) {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');
        if (!metaThemeColor) {
            metaThemeColor = document.createElement('meta');
            metaThemeColor.name = 'theme-color';
            document.head.appendChild(metaThemeColor);
        }
        metaThemeColor.content = color;
    }

    /**
     * Dispara evento personalizado cuando cambia el tema
     */
    dispatchThemeChangeEvent() {
        const event = new CustomEvent('themeChanged', {
            detail: { theme: this.currentTheme }
        });
        window.dispatchEvent(event);
    }

    /**
     * Obtiene el tema actual
     */
    getTheme() {
        return this.currentTheme;
    }

    /**
     * Verifica si el tema actual es oscuro
     */
    isDark() {
        return this.currentTheme === 'dark';
    }

    /**
     * Verifica si el tema actual es claro
     */
    isLight() {
        return this.currentTheme === 'light';
    }
}

// Inicializar theme manager globalmente
window.themeManager = new ThemeManager();

// Log para debugging (remover en producción)
console.log('🎨 Theme Manager initialized:', window.themeManager.getTheme());
