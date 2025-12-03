/**
 * Swift-Style Alert Pop-ups
 * Modern iOS-like alert system for web applications
 */

class SwiftAlert {
    constructor() {
        this.alertContainer = null;
        this.init();
    }

    init() {
        // Create alert container if it doesn't exist
        if (!document.getElementById('swift-alert-container')) {
            const container = document.createElement('div');
            container.id = 'swift-alert-container';
            container.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
                pointer-events: none;
            `;
            document.body.appendChild(container);
            this.alertContainer = container;
        } else {
            this.alertContainer = document.getElementById('swift-alert-container');
        }
    }

    show(options) {
        const {
            title = 'Alert',
            message = '',
            type = 'info', // 'info', 'success', 'warning', 'error'
            buttons = [{ text: 'OK', action: null }],
            duration = null
        } = options;

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'swift-alert-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: swiftFadeIn 0.3s ease-out;
        `;

        // Create alert box
        const alertBox = document.createElement('div');
        alertBox.className = 'swift-alert-box';
        alertBox.style.cssText = `
            background: white;
            border-radius: 14px;
            width: 90%;
            max-width: 300px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 10002;
            animation: swiftSlideUp 0.3s ease-out;
            pointer-events: auto;
        `;

        // Icon based on type
        const icons = {
            info: 'ℹ️',
            success: '✅',
            warning: '⚠️',
            error: '❌'
        };

        const colors = {
            info: '#007AFF',
            success: '#34C759',
            warning: '#FF9500',
            error: '#FF3B30'
        };

        // Alert content
        alertBox.innerHTML = `
            <div style="padding: 20px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">${icons[type] || icons.info}</div>
                <h3 style="margin: 0 0 8px 0; font-size: 17px; font-weight: 600; color: #000;">${title}</h3>
                ${message ? `<p style="margin: 0; font-size: 13px; color: #666; line-height: 1.4;">${message}</p>` : ''}
            </div>
            <div class="swift-alert-buttons" style="border-top: 0.5px solid #E5E5EA; display: flex;">
                ${buttons.map((btn, index) => {
                    const isLast = index === buttons.length - 1;
                    const isPrimary = btn.primary !== false && index === buttons.length - 1;
                    return `
                        <button 
                            class="swift-alert-button ${isPrimary ? 'primary' : ''}" 
                            data-action="${index}"
                            style="
                                flex: 1;
                                padding: 16px;
                                border: none;
                                background: white;
                                font-size: 17px;
                                font-weight: ${isPrimary ? '600' : '400'};
                                color: ${isPrimary ? colors[type] : '#007AFF'};
                                cursor: pointer;
                                ${!isLast ? 'border-right: 0.5px solid #E5E5EA;' : ''}
                                transition: background 0.2s;
                            "
                            onmouseover="this.style.background='#F2F2F7'"
                            onmouseout="this.style.background='white'"
                        >
                            ${btn.text}
                        </button>
                    `;
                }).join('')}
            </div>
        `;

        // Add to DOM
        document.body.appendChild(overlay);
        overlay.appendChild(alertBox);

        // Add animations
        this.addStyles();

        // Button handlers
        alertBox.querySelectorAll('.swift-alert-button').forEach((button, index) => {
            button.addEventListener('click', () => {
                const buttonConfig = buttons[index];
                if (buttonConfig.action && typeof buttonConfig.action === 'function') {
                    buttonConfig.action();
                }
                this.hide(overlay);
            });
        });

        // Overlay click to dismiss (if only one button)
        if (buttons.length === 1) {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    this.hide(overlay);
                }
            });
        }

        // Auto-dismiss if duration is set
        if (duration && duration > 0) {
            setTimeout(() => {
                this.hide(overlay);
            }, duration);
        }

        return overlay;
    }

    hide(overlay) {
        if (overlay) {
            overlay.style.animation = 'swiftFadeOut 0.2s ease-out';
            setTimeout(() => {
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }, 200);
        }
    }

    addStyles() {
        if (document.getElementById('swift-alert-styles')) return;

        const style = document.createElement('style');
        style.id = 'swift-alert-styles';
        style.textContent = `
            @keyframes swiftFadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes swiftFadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            @keyframes swiftSlideUp {
                from { 
                    transform: translateY(20px);
                    opacity: 0;
                }
                to { 
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Convenience methods
    info(title, message, buttons) {
        return this.show({ title, message, type: 'info', buttons });
    }

    success(title, message, buttons) {
        return this.show({ title, message, type: 'success', buttons });
    }

    warning(title, message, buttons) {
        return this.show({ title, message, type: 'warning', buttons });
    }

    error(title, message, buttons) {
        return this.show({ title, message, type: 'error', buttons });
    }

    confirm(title, message, onConfirm, onCancel) {
        return this.show({
            title,
            message,
            type: 'warning',
            buttons: [
                { text: 'Cancel', action: onCancel || null },
                { text: 'Confirm', action: onConfirm, primary: true }
            ]
        });
    }
}

// Initialize global instance
const swiftAlert = new SwiftAlert();

// Global helper functions for easy access
window.showSwiftAlert = (title, message, type = 'info') => {
    return swiftAlert.show({ title, message, type });
};

window.showSwiftSuccess = (title, message) => {
    return swiftAlert.success(title, message);
};

window.showSwiftError = (title, message) => {
    return swiftAlert.error(title, message);
};

window.showSwiftWarning = (title, message) => {
    return swiftAlert.warning(title, message);
};

window.showSwiftConfirm = (title, message, onConfirm, onCancel) => {
    return swiftAlert.confirm(title, message, onConfirm, onCancel);
};

