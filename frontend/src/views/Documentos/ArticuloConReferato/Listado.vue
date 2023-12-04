<template>
    <DefaultLayout>
        <h2 class="text-center">Listado de Articulo con Referato</h2>
        <router-link to="/articulo-referato/alta" class="text-center">Ir al alta</router-link>

        <table class="table mx-auto text-center">
            <thead>
                <tr>
                    <th scope="col">Nombre </th>
                    <th scope="col">Localidad</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Tipo de congreso</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="articulo in articulos" :key="articulo.id">
                    <td>{{ articulo.nombre }}</td>
                    <td>{{ articulo.articulo_con_referato.lugar }}</td>
                    <td>{{ articulo.articulo_con_referato.fecha }}</td>
                    <td>{{ articulo.articulo_con_referato.es_nacional ? 'Nacional ​ ​' : 'Internacional 🌎' }}</td>
                    <!-- Itera sobre los autores de este artículo -->
                    <span v-for="autor in articulo.autores" :key="autor.id">
                        {{ autor.nombre }} {{ autor.apellido }}
                    </span>
                    <button @click="verDetalles(articulo.articulo_con_referato.id)">Detalles</button>
                </tr>
            </tbody>
        </table>
    </DefaultLayout>
</template>

<script setup>

import DefaultLayout from '../../../layouts/DefaultLayout.vue';
import { ref, onMounted } from 'vue';
import { useArtReferatoStore } from '@/stores/articulo-con-referato';


const verDetalles = (articuloId) => {
    // Lógica para redireccionar o mostrar detalles del artículo con el ID especificado.
    console.log(`Ver detalles del artículo con ID: ${articuloId}`);
};
</script>
    
<script>
export default {
    async mounted() {
        const artReferatoStore = useArtReferatoStore();
        await artReferatoStore.listarArticulos()
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 200) {
                    this.articulos = data.data
                }
            })
    },
    data() {
        return {
            articulos: null,
        }
    }

}
</script>
<style scoped></style>
