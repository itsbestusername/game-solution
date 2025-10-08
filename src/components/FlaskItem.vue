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
      border: 3px solid grey;
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

    /* палитра для элементов по игре */
    .c-arrow { background: #E9967A; } /* стрелка */
    .c-circle { background: #64472c; } /* круг */
    .c-drop { background: #8B008B; } /* капля */
    .c-heart { background: #570000; } /* сердце */
    .c-lightning { background: #483D8B; } /* молния */
    .c-mystery { background: transparent; } /* вопрос */
    .c-pause { background: #8A2BE2; } /* пауза  */
    .c-pentagon { background: #ffd1e8; } /* пятиугольник */
    .c-plus { background: #006400; } /* плюс */
    .c-rectangle { background: #ff973c; } /* минус */
    .c-rhombus { background: #c40101; } /* ромб */
    .c-square { background: #DB7093; } /* квадрат */
    .c-star { background: #62e266; } /* звезда */
    .c-triangle { background: #81d4fa; } /* треугольник */

/* Адаптивность для планшетов */
@media (max-width: 768px) {
    .flask-item {
        width: 45px;
        height: 160px;
    }
    .flask-glass {
        border: 2px solid grey;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
    }
    .segment-icon {
        width: 60%;
        height: 60%;
    }
}

/* Адаптивность для мобильных */
@media (max-width: 480px) {
    .flask-item {
        width: 35px;
        height: 120px;
    }
    .flask-glass {
        border: 2px solid grey;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .segment-icon {
        width: 50%;
        height: 50%;
    }
}

/* Адаптивность для очень маленьких экранов */
@media (max-width: 360px) {
    .flask-item {
        width: 30px;
        height: 100px;
    }
    .flask-glass {
        border: 1px solid grey;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    .segment-icon {
        width: 45%;
        height: 45%;
    }
}
</style>