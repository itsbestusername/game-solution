<template>
    <div class="bot-link">
<a href="https://zeonbot.ru" target="_blank" rel="noopener noreferrer"><h3 class="bot-link-title">Бот для игры Puzzles & Survival</h3></a>
    </div>
</template>
<script>
export default {
    name: 'bot-link'
}
</script>
<style scoped>
.bot-link {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.bot-link a {
    color: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}
.bot-link-title {
    font-size: 20px;
    font-weight: 600;
}
.bot-link a:hover {
    text-decoration: underline;
}
.bot-link a::before {
    content: '👉 ';
    margin-right: 6px;
}

/* Адаптивность для планшетов */
@media (max-width: 768px) {
    .bot-link a::before {
        margin-right: 4px;
    }
    .bot-link-title {
        font-size: 18px;
    }
}

/* Адаптивность для мобильных */
@media (max-width: 480px) {
    .bot-link a::before {
        margin-right: 3px;
    }
    .bot-link-title {
        font-size: 16px;
    }
}

/* Адаптивность для очень маленьких экранов */
@media (max-width: 360px) {
    .bot-link a::before {
        margin-right: 2px;
    }
    .bot-link-title {
        font-size: 14px;
    }
}
</style>