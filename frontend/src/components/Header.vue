<script setup>
</script>

<template>
    <header class="border-bottom">
        <button class="btn menu-icon" @click="$emit('abrirMenu')">
            <i class="bi bi-list"></i>
        </button>
        <h1 class="title">GCC - Grupo 8</h1>
    </header>
</template>

<style scoped>
.menu-icon>i {
    font-size: 2em;
    margin-left: 0.25em;
    cursor: pointer;
}

header {
    background-color: white;
    min-height: 50px;
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
}

header>.title {
    margin-left: auto;
    margin-right: auto;
    font-size: 2em;
}

.btn:focus,
.btn:active,
.btn {
    border: 0;
    outline: 0;
    box-shadow: none;
    transition: 0s;

}
</style>
