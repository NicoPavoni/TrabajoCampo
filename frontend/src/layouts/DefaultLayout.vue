<style scoped>
.main-container {
    display: flex;
    min-height: 100vh;
    align-items: stretch;
}

main {
    display: flex;
    flex-direction: column;
}
</style>
<script setup>
import Sidebar from '../components/Sidebar.vue';
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
</script>
<template>
    <div class="main-container">
        <Sidebar :open="showSidebar" @cerrarSidebar="showSidebar = false"></Sidebar>
        <div class="d-flex flex-column w-100">
            <Header @abrirMenu="showSidebar = true">Este es el header</Header>
            <main>
                <slot></slot>
            </main>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            "showSidebar": true
        }
    }
}
</script>