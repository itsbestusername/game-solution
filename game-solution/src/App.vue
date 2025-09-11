<template>
    <div class="app">
        <bot-link />
        <h1>Загрузи фото головоломки и получи пошаговое решение</h1>
        <add-photo />
        <flask-player class="flask-desk" :capacity="4" />
        <div class="layout"></div>
    </div>
    
</template>

<script>
export default {}
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
    gap: 20px;
    position: relative;
    overflow-x: hidden; /* предотвратить горизонтальный скролл */
    color: #fff;
}
.flask-desk {
    width: 100%;
    height: 50%;
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
</style>