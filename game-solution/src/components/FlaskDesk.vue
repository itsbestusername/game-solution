<template>
    <div class="flask-desk">
        <div v-for="(segments, index) in flasks" :key="index" class="flask-cell">
            <div v-if="labels && labels[index] !== undefined" class="flask-label">{{ labels[index] }}</div>
            <flask-item :segments="segments" :capacity="capacity" />
        </div>
    </div>
    
</template>

<script>
export default {
    name: 'flask-desk',
    props: {
        flasks: { type: Array, default: () => [] },
        capacity: { type: Number, default: 4 },
        labels: { type: Array, default: null }
    }
}
</script>

<style scoped>
.flask-desk {
    width: 50%;
    height: 50%;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap; /* перенос на новую строку */
    align-content: flex-start; /* выравнивание нескольких рядов */
    gap: 10px;
}
.flask-cell {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.flask-label {
    color: #fff;
    margin-bottom: 6px;
    font-size: 12px;
}
</style>