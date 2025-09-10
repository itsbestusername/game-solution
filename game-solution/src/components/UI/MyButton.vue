<template>
    <button>
        <slot></slot>
    </button>
</template>
<script>
export default {
    name: 'my-button'
}
</script>
<style scoped>
button {
    padding: 10px 20px;
    background-color: #000;
    color: #fff;
}
</style>