<template>
    <div class="add-photo">
        <my-button class="button" @click="openFileDialog" :disabled="isUploading">
            <template v-if="!isUploading">
                <span class="button-text">Загрузить</span>
            </template>
            <template v-else>
                <div class="loading-content">
                    <span class="button-text-loading">Поиск решения. Подождите</span>
                    <div class="spinner"></div>
                </div>
            </template>
        </my-button>
        <input ref="photoInput" type="file" accept="image/*" @change="onFileChange" style="display: none;" />
        <div v-if="error" class="error">{{ error }}</div>
    </div>
</template>
<script>
export default {
    name: 'add-photo',
    data() {
        return {
            isUploading: false,
            error: null
        }
    },
    methods: {
        openFileDialog() {
            if (this.$refs.photoInput) {
                this.$refs.photoInput.click()
            }
        },
        async onFileChange(event) {
            const input = event.target
            const file = input && input.files && input.files[0]
            if (!file) return

            this.isUploading = true
            this.error = null

            try {
                const formData = new FormData()
                formData.append('file', file)

                // В режиме разработки используем Vite прокси, в продакшене - proxy.php
                const uploadEndpoint = import.meta.env.DEV 
                    ? '/api/solve-file' 
                    : './proxy.php'
                
                let response = await fetch(uploadEndpoint, {
                    method: 'POST',
                    body: formData
                })

                if (!response.ok) {
                    const errorText = await response.text()
                    console.error('Response error:', errorText)
                    
                    // Проверяем, является ли это ошибкой 503 с session_id
                    if (response.status === 503) {
                        try {
                            const errorData = JSON.parse(errorText)
                            if (errorData.detail && errorData.detail.session_id) {
                                // Эмитим событие с данными ошибки 503
                                this.$emit('error-503', {
                                    sessionId: errorData.detail.session_id,
                                    error: errorData.detail.error || 'Не удалось решить головоломку',
                                    errorCode: 503
                                })
                                return
                            }
                        } catch (parseError) {
                            console.error('Ошибка парсинга ответа 503:', parseError)
                        }
                    }
                    
                    // Для других ошибок также показываем модальное окно
                    this.$emit('error-503', {
                        sessionId: `error_${Date.now()}`,
                        error: `Ошибка сервера: ${response.status} ${response.statusText}`,
                        errorCode: response.status
                    })
                    return
                }

                const result = await response.json()
                console.log('Решение получено:', result)

                // Эмитим событие с результатом для родительского компонента
                this.$emit('solution-received', result)

            } catch (err) {
                console.error('Ошибка загрузки:', err)
                
                // Показываем модальное окно для любых ошибок
                this.$emit('error-503', {
                    sessionId: `network_error_${Date.now()}`,
                    error: err.message || 'Ошибка загрузки файла',
                    errorCode: null
                })
            } finally {
                this.isUploading = false
            }
        }
    }
}
</script>
<style scoped>
.add-photo {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 12px;
}
.button {
    min-width: 200px;
    min-height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}
.button-text {
    font-size: 18px;
    font-weight: 400;
}
.button-text-loading {
    font-size: 14px;
    font-weight: 400;
}
.loading-content {
    display: flex;
    align-items: center;
    gap: 12px;
}
.spinner {
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff40;
    border-top: 2px solid #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
.error {
    color: #ff6b6b;
    text-align: center;
    font-size: 14px;
    font-weight: 400;
    max-width: 80vw;
    word-wrap: break-word;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>