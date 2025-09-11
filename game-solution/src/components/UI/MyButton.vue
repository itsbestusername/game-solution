<template>
    <button type="button" @click="$emit('click', $event)">
        <slot></slot>
    </button>
</template>
<script>
export default {
    name: 'my-button',
    emits: ['click']
}
</script>
<style scoped>
button {
    padding: 10px 20px;
    background-color: #E76F04;
    color: #fff;
    border-radius: 6px;
}
</style>