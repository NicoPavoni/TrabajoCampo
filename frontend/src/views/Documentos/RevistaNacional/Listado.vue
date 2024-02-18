<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Publicaciónes en Revistas Nacionales</h2>

        <div class="modal" :class="{ 'd-block': modalEliminar.mostrar }" style="background-color: rgba(0,0,0,0.3)"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar publicación</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="cerrarModalEliminar()"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estas seguro que desea eliminar la publicación '{{ modalEliminar.nombre }}'?</p>
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
                <router-link to="/revista-nacional/alta" class="text-center btn btn-success"><i
                        class="bi bi-plus-lg me-2"></i>Nuevo</router-link>

                <div class="alert alert-success mx-auto p-2" v-if="exitoEliminar">Publicación '{{ modalEliminar.nombre
                }}' eliminado exitosamente
                </div>
            </div>

            <div class="overflow-auto mb-4 mt-3">
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre </th>
                            <th scope="col">Pais</th>
                            <th scope="col">ISSN</th>
                            <th scope="col">Con Referato</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for=" revista  in  revistas " :key="revista.id">
                            <td>{{ revista.nombre }}</td>
                            <td>{{ revista.revista_nacional.pais }}</td>
                            <td>{{ revista.revista_nacional.issn }}</td>
                            <td>{{ revista.revista_nacional.con_referato ? 'Sí' : 'No' }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(revista.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarRevistaNacional(revista.id)"></button>
                                <button class="bi bi-trash btn"
                                    @click="mostrarModalEliminar(revista.id, revista.nombre)"></button>
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

import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { ref, onMounted } from 'vue';
import { useRevistaNacionalStore } from '@/stores/revista-nacional';
import { useDocumentoStore } from '@/stores/documento';
import { createRouterMatcher, useRouter } from 'vue-router';

const router = useRouter();

const verDetalles = (documentoId) => {
    router.push("/revista-nacional/" + documentoId);
};
const editarRevistaNacional = (documentoId) => {
    router.push("/revista-nacional/" + documentoId + "/editar");
}
</script>
    
<script>
export default {
    async mounted() {
        const revistaNacionalStore = useRevistaNacionalStore();
        const docStore = useDocumentoStore();
        await revistaNacionalStore.listarRevistaNacionales()
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 200) {
                    this.revistas = data.data
                    this.loading = false;
                }
            })
        this.revistaNacionalStore = revistaNacionalStore;
        this.docStore = docStore;
    },
    data() {
        return {
            loading: true,
            revistas: null,
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
                        this.revistas = this.revistas.filter((revista) => revista.id != documentoId);
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
