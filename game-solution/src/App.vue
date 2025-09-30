<template>
    <div class="app">
        <bot-link />
        <h1>Загрузи фото головоломки и получи пошаговое решение</h1>
        <add-photo @solution-received="handleSolution" />
        <flask-player class="flask-desk" :capacity="4" :solution-data="solutionData" />
        <div class="layout"></div>
    </div>
    
</template>

<script>
export default {
    data() {
        return {
            solutionData: null
        }
    },
    methods: {
        handleSolution(solution) {
            console.log('Решение получено в App:', solution)
            this.solutionData = solution
        }
    }
}
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
}
.app {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100vw;
    height: 100vh;
    background: linear-gradient(to right, #211F1F, #323144);
    gap: 20px;
    position: relative;
    overflow-x: hidden; /* предотвратить горизонтальный скролл */
    color: #fff;
}

.app h1 {
    font-size: 28px;
    font-weight: 600;
    margin: 0;
}

.flask-desk {
    width: 90%;
    height: 50%;
    margin-top: 20px;
}
    .layout {
        width: 30%;
        height: 50%;
        background-image: url('./components/images/скарлет.svg');
        background-size: cover;
        position: absolute;
        bottom: 0;
        right: 0; 
        transform: translateX(25%);
    }

/* Адаптивность для планшетов */
@media (max-width: 768px) {
    .app {
        gap: 15px;
    }
    .app h1 {
        font-size: 24px;
    }
}

/* Адаптивность для мобильных */
@media (max-width: 480px) {
    .app {
        gap: 12px;
    }
    .app h1 {
        font-size: 20px;
    }
}

/* Адаптивность для очень маленьких экранов */
@media (max-width: 360px) {
    .app {
        gap: 10px;
    }
    .app h1 {
        font-size: 18px;
    }
}
</style>