<template>
    <div class="add-photo">
        <my-button class="button" @click="openFileDialog" :disabled="isUploading">
            <span v-if="!isUploading">Загрузить</span>
            <div v-else class="spinner"></div>
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

                const response = await fetch('/api/solve-file', {
                    method: 'POST',
                    body: formData
                })

                if (!response.ok) {
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
    justify-content: center;
    align-items: center;
}
.button {
    width: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
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
    margin-left: 12px;
    color: #ff6b6b;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>