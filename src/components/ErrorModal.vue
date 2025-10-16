<template>
    <div v-if="isVisible" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
            <div class="modal-header">
                <button class="close-button" @click="closeModal" aria-label="Закрыть">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="error-icon">⚠️</div>
                <p class="error-message">
                    {{ errorMessage }}
                </p>
                <div v-if="shouldShowSessionInfo" class="session-info">
                    <p class="session-label">ID сессии для обращения в техподдержку:</p>
                    <code class="session-id">{{ sessionId }}</code>
                </div>
                <div v-if="shouldShowSessionInfo" class="support-link">
                    <p class="support-message-text">
                        Техподдержка 👉 <a class="support-link-text" href="https://t.me/zeonbot_support" target="_blank">https://t.me/zeonbot_support</a>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <my-button @click="closeModal" class="close-modal-button">
                    Понятно
                </my-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ErrorModal',
    props: {
        isVisible: {
            type: Boolean,
            default: false
        },
        sessionId: {
            type: String,
            default: ''
        },
        errorCode: {
            type: Number,
            default: null
        }
    },
    computed: {
        errorMessage() {
            if (this.errorCode === 500) {
                return 'Сервер временно недоступен. Попробуйте позже.'
            }
            return 'К сожалению, не удалось решить головоломку. Возможно, изображение нечеткое или головоломка слишком сложная.'
        },
        shouldShowSessionInfo() {
            return this.errorCode !== 500
        }
    },
    methods: {
        closeModal() {
            this.$emit('close')
        }
    }
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}

.modal-content {
    background: linear-gradient(135deg, #2a2a2a, #3a3a3a);
    border-radius: 12px;
    padding: 0;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border: 1px solid #444;
}

.modal-header {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #444;
}

.close-button {
    background: none;
    border: none;
    color: #ccc;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.close-button:hover {
    background-color: #444;
    color: #fff;
}

.modal-body {
    padding: 24px;
    text-align: center;
}

.error-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.error-message {
    color: #fff;
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 24px;
}

.session-info {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    padding: 16px;
    border: 1px solid #444;
}

.session-label {
    color: #ccc;
    font-size: 14px;
    margin-bottom: 8px;
}

.session-id {
    background-color: rgba(0, 0, 0, 0.3);
    color: #fff;
    padding: 8px 12px;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    border: 1px solid #555;
    word-break: break-all;
    display: block;
    margin: 0 auto;
    max-width: 300px;
}

.support-link {
    margin-top: 20px;
}

.support-message-text {
    color: #ccc;
    font-size: 15px;
    line-height: 1.5;
    margin: 0;
}

.support-link-text {
    color: #66b3ff;
    text-decoration: none;
    transition: all 0.2s ease;
    border-bottom: 1px solid transparent;
}

.support-link-text:hover {
    color: #88c9ff;
    border-bottom-color: #88c9ff;
}

.modal-footer {
    padding: 16px 24px 24px;
    display: flex;
    justify-content: center;
}

.close-modal-button {
    min-width: 120px;
}

/* Анимация появления */
.modal-overlay {
    animation: fadeIn 0.3s ease-out;
}

.modal-content {
    animation: slideIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Адаптивность */
@media (max-width: 600px) {
    .modal-content {
        width: 95%;
        margin: 20px;
    }
    
    .modal-header {
        padding: 12px 16px;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .modal-footer {
        padding: 12px 20px 20px;
    }
    
    .session-id {
        max-width: 100%;
        text-align: center;
    }
}
</style>
