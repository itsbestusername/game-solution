<template>
    <div class="app">
        <bot-link class="bot-link"/>
        <h1>Загрузи фото головоломки и получи пошаговое решение</h1>
        <h3 class="description">Решаем головоломки любого уровня. Если в головоломке есть знаки вопроса - сначала раскрываем их. Когда все знаки вопроса раскрыты - решаем. После раскрытия знаков вопроса, сделайте еще один скриншот и загрузите повторно</h3>
        <add-photo @solution-received="handleSolution" @error-503="handleError503" />
        <flask-player class="flask-desk" :capacity="4" :solution-data="solutionData" />
        <div class="layout"></div>
        
        <!-- Модальное окно ошибки -->
        <error-modal 
            :is-visible="showErrorModal" 
            :session-id="errorSessionId"
            :error-code="errorCode"
            @close="closeErrorModal" 
        />
    </div>
    
</template>

<script>
import ErrorModal from './components/ErrorModal.vue'

export default {
    components: {
        ErrorModal
    },
    data() {
        return {
            solutionData: null,
            showErrorModal: false,
            errorSessionId: '',
            errorCode: null
        }
    },
    methods: {
        handleSolution(solution) {
            console.log('Решение получено в App:', solution)
            this.solutionData = solution
        },
        handleError503(errorData) {
            console.log('Ошибка получена в App:', errorData)
            this.errorSessionId = errorData.sessionId
            this.errorCode = errorData.errorCode
            this.showErrorModal = true
        },
        closeErrorModal() {
            this.showErrorModal = false
            this.errorSessionId = ''
            this.errorCode = null
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
    min-height: 100vh;
    background: linear-gradient(to right, #211F1F, #323144);
    gap: 15px;
    position: relative;
    overflow-x: hidden;
    color: #fff;
    padding: 20px 0;
    box-sizing: border-box;
}
.bot-link {
margin-bottom: 20px;
}
.app h1 {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
    line-height: 1.2;
}
.description {
    max-width: 60%;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.4;
    margin: 0;
}
.flask-desk {
    width: 80%;
    max-width: 600px;
    margin-top: 10px;
    min-height: 0;
}
.layout {
    width: 35%;
    height: 50%;
    background-image: url('./components/images/скарлет.svg');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: bottom right;
    position: absolute;
    bottom: 0;
    right: 0;
    opacity: 0.9;
    z-index: 1;
}

/* Адаптивность для планшетов */
@media (max-width: 848px) {
    .app {
        gap: 12px;
        padding: 15px 0;
    }
    .app h1 {
        font-size: 20px;
    }
    .description {
        font-size: 12px;
        max-width: 85%;
    }
    .flask-desk {
        width: 85%;
        margin-top: 8px;
    }
    .layout {
        display: none;
    }
}

/* Адаптивность для мобильных */
@media (max-width: 480px) {
    .app {
        gap: 10px;
        padding: 10px 0;
    }
    .app h1 {
        font-size: 18px;
    }
    .description {
        font-size: 11px;
        max-width: 90%;
    }
    .flask-desk {
        width: 90%;
        margin-top: 5px;
    }
    .layout {
        display: none;
    }
}

/* Адаптивность для очень маленьких экранов */
@media (max-width: 360px) {
    .app {
        gap: 8px;
        padding: 8px 0;
    }
    .app h1 {
        font-size: 16px;
    }
    .description {
        font-size: 10px;
        max-width: 95%;
    }
    .flask-desk {
        width: 95%;
        margin-top: 3px;
    }
    .layout {
        display: none;
    }
}
</style>