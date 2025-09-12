<template>
    <div class="flask-item">
        <div class="flask-glass">
            <div class="flask-segments" :style="{ '--capacity': capacity, '--filled': Math.min(segments.length, capacity) }">
                <!-- порядок элементов: снизу -> вверх -->
                <div v-for="(s, idx) in segments" :key="idx" class="segment" :class="colorClass(s)">
                    <img v-if="iconSrc(s)" class="segment-icon" :src="iconSrc(s)" :alt="s" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import arrowIcon from './images/arrow.png'
import circleIcon from './images/circle.png'
import dropIcon from './images/drop.png'
import heartIcon from './images/heart.png'
import lightningIcon from './images/lightning.png'
import mysteryIcon from './images/mystery.png'
import pauseIcon from './images/pause.png'
import pentagonIcon from './images/pentagon.png'
import plusIcon from './images/plus.png'
import rectangleIcon from './images/rectangle.png'
import rhombusIcon from './images/rhombus.png'
import squareIcon from './images/square.png'
import starIcon from './images/star.png'
import triangleIcon from './images/triangle.png'

const COLOR_BY_SYMBOL = {
    ARROW: 'c-arrow',
    CIRCLE: 'c-circle',
    DROP: 'c-drop',
    HEART: 'c-heart',
    LIGHTNING: 'c-lightning',
    MYSTERY: 'c-mystery',
    PAUSE: 'c-pause',
    PENTAGON: 'c-pentagon',
    PLUS: 'c-plus',
    RECTANGLE: 'c-rectangle',
    RHOMBUS: 'c-rhombus',
    SQUARE: 'c-square',
    STAR: 'c-star',
    TRIANGLE: 'c-triangle'
}

const ICON_BY_SYMBOL = {
    ARROW: arrowIcon,
    CIRCLE: circleIcon,
    DROP: dropIcon,
    HEART: heartIcon,
    LIGHTNING: lightningIcon,
    MYSTERY: mysteryIcon,
    PAUSE: pauseIcon,
    PENTAGON: pentagonIcon,
    PLUS: plusIcon,
    RECTANGLE: rectangleIcon,
    RHOMBUS: rhombusIcon,
    SQUARE: squareIcon,
    STAR: starIcon,
    TRIANGLE: triangleIcon
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
        },
        iconSrc(symbol) {
            return ICON_BY_SYMBOL[symbol] || null
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
    .segment { flex: 0 0 calc(100% / var(--capacity)); width: 100%; display: flex; align-items: center; justify-content: center; }
    .segment-icon { width: 70%; height: 70%; object-fit: contain; }

    /* палитра для элементов */
    .c-arrow { background: #f4c542; }
    .c-circle { background: #6aa9ff; }
    .c-drop { background: #00bcd4; }
    .c-heart { background: #e57373; }
    .c-lightning { background: #ffd54f; }
    .c-mystery { background: #9c27b0; }
    .c-pause { background: #90a4ae; }
    .c-pentagon { background: #8d6e63; }
    .c-plus { background: #81c784; }
    .c-rectangle { background: #4db6ac; }
    .c-rhombus { background: #9575cd; }
    .c-square { background: #64b5c2; }
    .c-star { background: #ffd740; }
    .c-triangle { background: #ff8a65; }
</style>