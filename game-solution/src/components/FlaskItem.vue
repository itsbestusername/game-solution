<template>
    <div class="flask-item">
        <div class="flask-glass">
            <div class="flask-segments" :style="{ '--capacity': capacity, '--filled': Math.min(segments.length, capacity) }">
                <!-- порядок элементов: снизу -> вверх -->
                <div v-for="(s, idx) in segments" :key="idx" class="segment" :class="colorClass(s)"></div>
            </div>
        </div>
    </div>
</template>

<script>
const COLOR_BY_SYMBOL = {
    PINK: 'c-pink',
    PURPLE: 'c-purple',
    BLUE: 'c-blue',
    GREEN: 'c-green',
    MYSTERY: 'c-purple'
}

export default {
    name: 'flask-item',
    props: {
        segments: { type: Array, default: () => [] },
        capacity: { type: Number, default: 4 }
    },
    methods: {
        colorClass(symbol) {
            return COLOR_BY_SYMBOL[symbol] || 'c-pink'
        }
    }
}
</script>

<style scoped>
.flask-item {
 width: 56px; height: 200px; position: relative; }
    .flask-glass {
      width: 100%; height: 100%;
      border: 4px solid grey;
      border-top-left-radius: 6px; border-top-right-radius: 6px;
      border-bottom-left-radius: 24px; border-bottom-right-radius: 24px;
      background: transparent; overflow: hidden;
    }
    .flask-segments {
      height: 100%;
      display: flex;
      flex-direction: column-reverse; /* снизу -> вверх */
      padding: 4px 0 0;
    }
    .flask-segments::after {
      content: '';
      flex: 0 0 calc((var(--capacity) - var(--filled)) * (100% / var(--capacity)));
    }
    .segment { flex: 0 0 calc(100% / var(--capacity)); width: 100%; }
    
    /* палитра на время верстки */
    .c-pink { background: #e595c9; }
    .c-purple { background: #a67bd7; }
    .c-blue { background: #3c4ad8; }
    .c-green { background: #4bd182; }
</style>