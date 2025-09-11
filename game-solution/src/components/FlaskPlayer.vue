<template>
    <div class="flask-player">
        <h3 class="title">{{ currentTitle }} из {{ totalSteps }}</h3>

        <div class="controls">
            <my-button :disabled="isFirst" @click="prevStep">Назад</my-button>
            <my-button :disabled="isLast" @click="nextStep">Вперёд</my-button>
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
        capacity: { type: Number, default: 4 }
    },
    data() {
        const stepsObject = mockSolution.solution
        const stepKeys = Object.keys(stepsObject)
            .sort((a, b) => Number(a.split('_')[1]) - Number(b.split('_')[1]))

        const steps = stepKeys.map((key) => stepsObject[key])

        return {
            steps,
            stepIndex: 0
        }
    },
    computed: {
        totalSteps() {
            return this.steps.length;
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
}
.desk {
    max-width: 50%;
}
.controls {
    display: flex;
    align-items: center;
    gap: 12px;
}
.step-indicator {
    color: #fff;
}
</style>