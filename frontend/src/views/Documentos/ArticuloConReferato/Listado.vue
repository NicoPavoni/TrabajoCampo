<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Artículo con Referato</h2>

        <div class="modal" :class="{ 'd-block': modalEliminar.mostrar }" style="background-color: rgba(0,0,0,0.3)"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar artículo con referato</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="cerrarModalEliminar()"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estas seguro que desea eliminar el articulo '{{ modalEliminar.nombre }}'?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalEliminar()">Cerrar</button>
                        <button type="button" class="btn btn-danger" @click="eliminarArticulo(modalEliminar.id)"
                            :disabled="modalEliminar.loading"><span class="spinner-border spinner-border-sm me-1"
                                role="status" aria-hidden="true" v-if="modalEliminar.loading"></span>Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container" v-if="!loading">
            <div class="d-flex align-items-center mt-4">
                <router-link to="/articulo-referato/alta" class="text-center btn btn-success"><i
                        class="bi bi-plus-lg me-2"></i>Nuevo</router-link>

                <div class="alert alert-success mx-auto p-2" v-if="exitoEliminar">Articulo '{{ modalEliminar.nombre
                }}' eliminado exitosamente
                </div>
            </div>

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
                        <tr v-for=" articulo  in  articulos " :key="articulo.id">
                            <td>{{ articulo.nombre }}</td>
                            <td>{{ articulo.articulo_con_referato.lugar }}</td>
                            <td>{{ articulo.articulo_con_referato.fecha }}</td>
                            <td>{{ articulo.articulo_con_referato.es_nacional ? 'Nacional 🇦🇷' : 'Internacional 🌎' }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(articulo.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarArticulo(articulo.id)"></button>
                                <button class="bi bi-trash btn"
                                    @click="mostrarModalEliminar(articulo.id, articulo.nombre)"></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="align-self-center p-5" v-else>
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem" role="status">
                <span class="visually-hidden">Loading...</span>
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
                    this.loading = false;
                }
            })
        this.artReferatoStore = artReferatoStore;
    },
    data() {
        return {
            loading: true,
            articulos: null,
            modalEliminar: {
                mostrar: false,
                id: 0,
                nombre: undefined,
                loading: false
            },
            exitoEliminar: false,
            documentoId: undefined,
        }
    },
    methods: {
        async eliminarArticulo(documentoId) {
            this.modalEliminar.loading = true;
            await this.artReferatoStore.eliminarArtReferato(documentoId)
                .catch(e => console.error(e))
                .then(data => {
                    if (data.status == 200) {
                        this.exitoEliminar = true;
                        this.articulos = this.articulos.filter((articulo) => articulo.id != documentoId);
                        this.modalEliminar.mostrar = false;
                        this.modalEliminar.loading = false;
                    }
                })
        },
        mostrarModalEliminar(id, nombre) {
            this.modalEliminar.mostrar = true;
            this.modalEliminar.id = id;
            this.modalEliminar.nombre = nombre;
            this.exitoEliminar = false;
        },
        cerrarModalEliminar() {
            this.modalEliminar = {
                mostrar: false,
                id: 0,
                nombre: undefined
            }
        }
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
