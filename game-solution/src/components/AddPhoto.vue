<template>
    <div class="add-photo">
        <my-button @click="openFileDialog">Загрузить фото</my-button>
        <input ref="photoInput" type="file" accept="image/*" @change="onFileChange" style="display: none;" />
    </div>
</template>
<script>
export default {
    name: 'add-photo',
    methods: {
        openFileDialog() {
            if (this.$refs.photoInput) {
                this.$refs.photoInput.click()
            }
        },
        onFileChange(event) {
            const input = event.target
            const file = input && input.files && input.files[0]
            if (file) {
                // Временно просто покажем в консоли, что файл выбран
                console.log('Выбран файл:', file.name)
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
</style>