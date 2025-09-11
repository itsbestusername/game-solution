<template>
    <div class="bot-link">
<a href="https://zeonbot.ru" target="_blank" rel="noopener noreferrer"><h3>Бот для игры Puzzles & Survival</h3></a>
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
.bot-link a:hover {
    text-decoration: underline;
}
.bot-link a::before {
    content: '👉 ';
    margin-right: 6px;
}
</style>