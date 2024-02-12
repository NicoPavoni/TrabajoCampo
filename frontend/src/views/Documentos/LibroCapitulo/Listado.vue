<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Libros y Capitulos</h2>

        <div class="modal" :class="{ 'd-block': modalEliminar.mostrar }" style="background-color: rgba(0,0,0,0.3)"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar libro/capitulo</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="cerrarModalEliminar()"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estas seguro que desea eliminar el libro/capitulo '{{ modalEliminar.nombre }}'?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalEliminar()">Cerrar</button>
                        <button type="button" class="btn btn-danger" @click="eliminarDocumento(modalEliminar.id)"
                            :disabled="modalEliminar.loading"><span class="spinner-border spinner-border-sm me-1"
                                role="status" aria-hidden="true" v-if="modalEliminar.loading"></span>Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container" v-if="!loading">
            <div class="d-flex align-items-center mt-4">
                <router-link to="/libro-capitulo/alta" class="text-center btn btn-success"><i
                        class="bi bi-plus-lg me-2"></i>Nuevo</router-link>

                <div class="alert alert-success mx-auto p-2" v-if="exitoEliminar">Libro/Capitulo '{{ modalEliminar.nombre
                }}' eliminado exitosamente
                </div>
            </div>

            <div class="overflow-auto mb-4 mt-3">
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre </th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Editorial</th>
                            <th scope="col">N° Capitulo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for=" libroCapitulo  in  librosCapitulos " :key="libroCapitulo.id">
                            <td>{{ libroCapitulo.nombre }}</td>
                            <td>{{ libroCapitulo.libro_capitulo.isbn }}</td>
                            <td>{{ libroCapitulo.libro_capitulo.editorial }}</td>
                            <td>{{ libroCapitulo.libro_capitulo.nro_capitulo ? libroCapitulo.libro_capitulo.nro_capitulo :
                                '-' }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(libroCapitulo.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarLibroCapitulo(libroCapitulo.id)"></button>
                                <button class="bi bi-trash btn"
                                    @click="mostrarModalEliminar(libroCapitulo.id, libroCapitulo.nombre)"></button>
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
import { useLibroCapituloStore } from '@/stores/libro-capitulo';
import { useDocumentoStore } from '@/stores/documento';
import { createRouterMatcher, useRouter } from 'vue-router';

const router = useRouter();

const verDetalles = (documentoId) => {
    router.push("/libro-capitulo/" + documentoId);
};
const editarLibroCapitulo = (documentoId) => {
    router.push("/libro-capitulo/" + documentoId + "/editar");
}
</script>
    
<script>
export default {
    async mounted() {
        const libroCapituloStore = useLibroCapituloStore();
        const docStore = useDocumentoStore();
        await libroCapituloStore.listarLibroCapitulos()
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 200) {
                    this.librosCapitulos = data.data
                    this.loading = false;
                }
            })
        this.libroCapituloStore = libroCapituloStore;
        this.docStore = docStore;
    },
    data() {
        return {
            loading: true,
            librosCapitulos: null,
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
        async eliminarDocumento(documentoId) {
            this.modalEliminar.loading = true;
            await this.docStore.eliminarDocumento(documentoId)
                .catch(e => console.error(e))
                .then(data => {
                    if (data.status == 200) {
                        this.exitoEliminar = true;
                        this.librosCapitulos = this.librosCapitulos.filter((librosCapitulo) => librosCapitulo.id != documentoId);
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
