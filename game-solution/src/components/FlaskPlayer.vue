<template>
    <div class="flask-player">
        <div v-if="hasSolution">
            <h3  class="title">{{ currentTitle }}</h3>
            <p>Всего шагов: {{ totalSteps }}</p>
        </div>
        <div v-else>
            <h3 class="title">{{ mockTitle }}</h3>
            <p>Всего шагов: {{ mockTotalSteps }}</p>
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
            return this.currentStep?.title || ''
        },
        mockTitle() {
            return this.mockSteps[this.stepIndex]?.title || ''
        },
        currentFlasks() {
            return this.currentStep ? stepFlasksToArray(this.currentStep) : []
        },
        currentLabels() {
            return this.currentStep
                ? stepFlaskLabels(this.currentStep).map((id) => String(Number(id) + 1))
                : []
        },
    },
    methods: {
        prevStep() {
            if (!this.isFirst) this.stepIndex -= 1
        },
        nextStep() {
            if (!this.isLast) this.stepIndex += 1
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
    gap: 20px;
}
.title {
    color: #fff;
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: 600;
}
.desk {
    max-width: 50%;
}
.controls {
    display: flex;
    align-items: center;
    gap: 12px;
}
.control-button {
    font-family: 'Montserrat', sans-serif;
    font-size: 16px;
    font-weight: 400;
    width: 100px;
    height: 40px;
}
.step-indicator {
    color: #fff;
}

/* Адаптивность для планшетов */
@media (max-width: 768px) {
    .title {
        font-size: 16px;
        margin-bottom: 8px;
    }
    .controls {
        gap: 10px;
    }
}

/* Адаптивность для мобильных */
@media (max-width: 480px) {
    .title {
        font-size: 14px;
        margin-bottom: 6px;
    }
    .controls {
        gap: 8px;
    }
}

/* Адаптивность для очень маленьких экранов */
@media (max-width: 360px) {
    .title {
        font-size: 12px;
        margin-bottom: 4px;
    }
    .controls {
        gap: 6px;
    }
}
</style>