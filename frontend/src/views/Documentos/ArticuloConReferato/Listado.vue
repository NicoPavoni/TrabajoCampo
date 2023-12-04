<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Articulo con Referato</h2>

        <div class="container">
            <router-link to="/articulo-referato/alta" class="text-center btn btn-success"><i
                    class="bi bi-plus-lg me-2"></i>Nuevo</router-link>
            <div class="overflow-auto mb-4 mt-3">
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
                            <td>{{ articulo.articulo_con_referato.es_nacional ? 'Nacional 🇦🇷' : 'Internacional 🌎' }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(articulo.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarArticulo(articulo.id)"></button>
                                <button class="bi bi-trash btn" @click="eliminarArticulo(articulo.id)"></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DefaultLayout>
</template>

<script setup>

import DefaultLayout from '../../../layouts/DefaultLayout.vue';
import { ref, onMounted } from 'vue';
import { useArtReferatoStore } from '@/stores/articulo-con-referato';
import { createRouterMatcher, useRouter } from 'vue-router';

const router = useRouter();

const verDetalles = (documentoId) => {
    router.push("/articulo-referato/" + documentoId);
};
const editarArticulo = (documentoId) => {
    router.push("/articulo-referato/" + documentoId + "/editar");
}
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
        this.artReferatoStore = artReferatoStore;
    },
    data() {
        return {
            articulos: null,
        }
    },
    methods: {
        async eliminarArticulo(documentoId) {
            if (window.confirm("¿Estas seguro que desea eliminarlo?")) {
                await this.artReferatoStore.eliminarArtReferato(documentoId)
                    .catch(e => console.error(e))
                    .then(data => {
                        if (data.status == 200) {
                            window.alert("Articulo con referato eliminado exitosamente");
                            this.articulos = this.articulos.filter((articulo) => articulo.id != documentoId);
                        }
                    })
            }
        },
    }
}
</script>
<style scoped>
.btn {
    border: 0;
    outline: 0;
    box-shadow: none;
    transition: 0s;

}
</style>
