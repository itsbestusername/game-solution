<template>
    <div class="flask-player">
        <div v-if="hasSolution">
            <div class="move-info-container">
                <div v-if="currentStep && currentStep.move" class="move-info">
                    <span class="count-text">{{ currentStep.move.count }} x </span>
                    <img :src="getElementImage(currentStep.move.element)" :alt="currentStep.move.element" class="element-image" @error="handleImageError" />
                </div>
                <h3 class="title">{{ currentTitle }}</h3>
            </div>
            <p>Всего шагов: {{ totalSteps-1 }}</p>
        </div>
        <div v-else>
            <div class="move-info-container">
                <div v-if="mockSteps[stepIndex] && mockSteps[stepIndex].move" class="move-info">
                    <span class="count-text">{{ mockSteps[stepIndex].move.count }} x </span>
                    <img :src="getElementImage(mockSteps[stepIndex].move.element)" :alt="mockSteps[stepIndex].move.element" class="element-image" @error="handleImageError" />
                </div>
                <h3 class="title">{{ mockTitle }}</h3>
            </div>
            <p>Всего шагов: {{ mockTotalSteps-1 }}</p>
        </div>

        <div class="controls">
            <my-button class="control-button" :disabled="isFirst" @click="prevStep">Назад</my-button>
            <my-button class="control-button" :disabled="isLast" @click="nextStep">Вперёд</my-button>
        </div>

        <flask-desk class="desk" :flasks="currentFlasks" :labels="currentLabels" :capacity="capacity" />
    </div>
    
</template>
<script>
import mockSolution from '../mocks/solution.mock.json'
import { stepFlasksToArray, stepFlaskLabels } from '../utils/solution.ts'
import heartImg from './images/heart.png'
import starImg from './images/star.png'
import circleImg from './images/circle.png'
import squareImg from './images/square.png'
import triangleImg from './images/triangle.png'
import pentagonImg from './images/pentagon.png'
import rhombusImg from './images/rhombus.png'
import rectangleImg from './images/rectangle.png'
import lightningImg from './images/lightning.png'
import dropImg from './images/drop.png'
import arrowImg from './images/arrow.png'
import plusImg from './images/plus.png'
import pauseImg from './images/pause.png'
import mysteryImg from './images/mystery.png'

export default {
    name: 'flask-player',
    props: {
        capacity: { type: Number, default: 4 },
        solutionData: { type: Object, default: null }
    },
    data() {
        // Инициализируем моковые данные
        const stepsObject = mockSolution.solution
        const stepKeys = Object.keys(stepsObject)
            .sort((a, b) => Number(a.split('_')[1]) - Number(b.split('_')[1]))
        const mockSteps = stepKeys.map((key) => stepsObject[key])

        return {
            stepIndex: 0,
            mockSteps
        }
    },
    computed: {
        hasSolution() {
            return this.solutionData && this.solutionData.solution
        },
        steps() {
            if (!this.hasSolution) {
                // Используем моковые данные если нет решения
                return this.mockSteps
            }
            
            // Используем данные с сервера
            const stepsObject = this.solutionData.solution
            const stepKeys = Object.keys(stepsObject)
                .sort((a, b) => Number(a.split('_')[1]) - Number(b.split('_')[1]))
            return stepKeys.map((key) => stepsObject[key])
        },
        totalSteps() {
            return this.steps.length;
        },
        mockTotalSteps() {
            return this.mockSteps.length;
        },
        isFirst() {
            return this.stepIndex <= 0
        },
        isLast() {
            return this.stepIndex >= this.steps.length - 1
        },
        currentStep() {
            return this.steps[this.stepIndex]
        },
        currentTitle() {
            if (!this.currentStep) return ''
            
            // Если это начальное состояние (нет move)
            if (!this.currentStep.move) {
                return 'Начальное состояние'
            }
            
            // Формируем название из move объекта
            return `Из колбы ${this.currentStep.move.from} → В колбу ${this.currentStep.move.to}`
        },
        mockTitle() {
            const mockStep = this.mockSteps[this.stepIndex]
            if (!mockStep) return ''
            
            // Если это начальное состояние (нет move)
            if (!mockStep.move) {
                return 'Начальное состояние'
            }
            
            // Формируем название из move объекта
            return `Из колбы ${mockStep.move.from} → В колбу ${mockStep.move.to}`
        },
        currentFlasks() {
            return this.currentStep ? stepFlasksToArray(this.currentStep) : []
        },
        currentLabels() {
            return this.currentStep
                ? stepFlaskLabels(this.currentStep).map((id) => String(Number(id) + 1))
                : []
        },
        elementImages() {
            return {
                'HEART': heartImg,
                'STAR': starImg,
                'CIRCLE': circleImg,
                'SQUARE': squareImg,
                'TRIANGLE': triangleImg,
                'PENTAGON': pentagonImg,
                'RHOMBUS': rhombusImg,
                'RECTANGLE': rectangleImg,
                'LIGHTNING': lightningImg,
                'DROP': dropImg,
                'ARROW': arrowImg,
                'PLUS': plusImg,
                'PAUSE': pauseImg,
                'MYSTERY': mysteryImg
            }
        },
    },
    methods: {
        prevStep() {
            if (!this.isFirst) this.stepIndex -= 1
        },
        nextStep() {
            if (!this.isLast) this.stepIndex += 1
        },
        getElementImage(element) {
            return this.elementImages[element] || mysteryImg
        },
        handleImageError(event) {
            console.error('Ошибка загрузки картинки:', event.target.src)
            // Устанавливаем mystery картинку как fallback
            event.target.src = mysteryImg
            // Предотвращаем повторные попытки загрузки
            event.target.onerror = null
        }
    },
    watch: {
        solutionData() {
            // Сбрасываем на первый шаг при получении нового решения
            this.stepIndex = 0
        }
    }
}
</script>
<style scoped>
.flask-player {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    width: 100%;
    height: 100%;
    justify-content: space-between;
}
.title {
    color: #fff;
    margin: 0;
    font-size: 16px;
    font-weight: 500;
    text-align: center;
    line-height: 24px;
}
.move-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.move-info-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 8px;
}
.count-text {
    color: #fff;
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
}
.element-image {
    width: 16px;
    height: 16px;
    object-fit: contain;
    display: block;
}
.desk {
    width: 100%;
    flex: 1;
    min-height: 0;
}
.controls {
    display: flex;
    align-items: center;
    gap: 12px;
}
.control-button {
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: 400;
    width: 90px;
    height: 35px;
}
.step-indicator {
    color: #fff;
}

/* Адаптивность для планшетов */
@media (max-width: 768px) {
    .flask-player {
        gap: 12px;
    }
    .title {
        font-size: 14px;
        line-height: 20px;
    }
    .move-info-container {
        margin-bottom: 6px;
    }
    .count-text {
        font-size: 14px;
        line-height: 20px;
    }
    .element-image {
        width: 20px;
        height: 20px;
    }
    .controls {
        gap: 10px;
    }
    .control-button {
        font-size: 13px;
        width: 80px;
        height: 32px;
    }
}

/* Адаптивность для мобильных */
@media (max-width: 480px) {
    .flask-player {
        gap: 10px;
    }
    .title {
        font-size: 13px;
        line-height: 18px;
    }
    .move-info-container {
        margin-bottom: 5px;
    }
    .count-text {
        font-size: 13px;
        line-height: 18px;
    }
    .element-image {
        width: 18px;
        height: 18px;
    }
    .controls {
        gap: 8px;
    }
    .control-button {
        font-size: 12px;
        width: 75px;
        height: 30px;
    }
}

/* Адаптивность для очень маленьких экранов */
@media (max-width: 360px) {
    .flask-player {
        gap: 8px;
    }
    .title {
        font-size: 12px;
        line-height: 16px;
    }
    .move-info-container {
        margin-bottom: 4px;
    }
    .count-text {
        font-size: 12px;
        line-height: 16px;
    }
    .element-image {
        width: 16px;
        height: 16px;
    }
    .controls {
        gap: 6px;
    }
    .control-button {
        font-size: 11px;
        width: 70px;
        height: 28px;
    }
}
</style>