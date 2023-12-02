<style scoped>
img.home-cover {
    max-width: 350px;
    align-self: center;
    margin-top: 1.5em;
}

@media(min-width:768px) {
    img.home-cover {
        max-width: 600px;
    }
}
</style>
<script setup>
import DefaultLayout from '../layouts/DefaultLayout.vue';
</script>
<template>
    <DefaultLayout>
        <h1 class="text-center mt-5 mx-3">Bienvenido al Módulo de Gestión de Comunicaciones Científicas.</h1>
        <img src="../../assets/img/100tifica-utn.png" alt="Home cover" class="home-cover">
        <p class="text-center mt-5 mx-3 w-lg-25 h4">En este módulo vas a encontrar detalles sobre trabajos
            publicados,
            reuniones
            científicas
            y
            sus expositores.</p>
    </DefaultLayout>
</template>

<script>
import axios from 'axios';
export default {
}
</script>