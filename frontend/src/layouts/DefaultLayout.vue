<style scoped>
.main-container {
    display: flex;
    min-height: 100vh;
    align-items: stretch;
}
</style>
<script setup>
import Sidebar from '../components/Sidebar.vue';
import Header from '../components/Header.vue';
</script>
<template>
    <div class="main-container">
        <Sidebar></Sidebar>
        <div class="d-flex flex-column w-100">
            <Header>Este es el header</Header>
            <main>
                <slot></slot>
            </main>
            <footer>Aca va el footer</footer>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
}
</script>