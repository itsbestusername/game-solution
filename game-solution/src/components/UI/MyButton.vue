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
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    transition: background-color 0.2s ease;
}

button:hover {
    background-color: #d76503;
}

button:disabled {
    background-color: #666;
    cursor: not-allowed;
    opacity: 0.6;
}
</style>