<template>
    <div class="app">
        <my-button>Загрузить фото</my-button>
        <flask-desk class="flask-desk" :flasks="flasks" :capacity="4" />
    </div>
    
</template>

<script>
import mockSolution from './mocks/solution.mock.json'
import { stepFlasksToArray } from './utils/solution.ts'

export default {
    data() {
        const step0 = mockSolution.solution.step_0
        return {
            flasks: stepFlasksToArray(step0)
        }
    }
}
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.app {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    background: linear-gradient(to right, #211F1F, #323144);
}
.flask-desk {
    max-width: 500px;
}
</style>