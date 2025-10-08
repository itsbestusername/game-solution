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

                // Используем прокси для обхода SSL проблем
                const uploadEndpoint = import.meta.env.VITE_UPLOAD_ENDPOINT || './proxy.php'
                
                let response = await fetch(uploadEndpoint, {
                    method: 'POST',
                    body: formData
                })

                if (!response.ok) {
                    const errorText = await response.text()
                    console.error('Response error:', errorText)
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`)
                }

                const result = await response.json()
                console.log('Решение получено:', result)

                // Эмитим событие с результатом для родительского компонента
                this.$emit('solution-received', result)

            } catch (err) {
                console.error('Ошибка загрузки:', err)
                this.error = err.message || 'Ошибка загрузки файла'
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