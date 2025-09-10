<template>
    <div class="flask-desk">
        <flask-item v-for="(segments, index) in flasks" :key="index" :segments="segments" :capacity="capacity" />
    </div>
</template>

<script>
export default {
    name: 'flask-desk',
    props: {
        flasks: { type: Array, default: () => [] },
        capacity: { type: Number, default: 4 }
    }
}
</script>

<style scoped>
.flask-desk {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 10px;
}
</style>