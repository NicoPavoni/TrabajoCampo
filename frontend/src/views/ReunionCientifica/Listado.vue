<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Reuniónes Científicas</h2>

        <div class="modal" :class="{ 'd-block': modalEliminar.mostrar }" style="background-color: rgba(0,0,0,0.3)"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar reunión cientifica</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="cerrarModalEliminar()"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea eliminar la reunión '{{ modalEliminar.nombre }}'?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalEliminar()">Cerrar</button>
                        <button type="button" class="btn btn-danger" @click="eliminarReunion(modalEliminar.id)"
                            :disabled="modalEliminar.loading"><span class="spinner-border spinner-border-sm me-1"
                                role="status" aria-hidden="true" v-if="modalEliminar.loading"></span>Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container" v-if="!loading">
            <div class="d-flex align-items-center mt-4">
                <router-link to="/reunion-cientifica/alta" class="text-center btn btn-success"><i
                        class="bi bi-plus-lg me-2"></i>Nuevo</router-link>

                <div class="alert alert-success mx-auto p-2" v-if="exitoEliminar">Reunión '{{ modalEliminar.nombre
                }}' eliminado exitosamente
                </div>
            </div>

            <div class="overflow-auto mb-4 mt-3">
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre </th>
                            <th scope="col">Fecha de Inicio</th>
                            <th scope="col">Ciudad/País</th>
                            <th scope="col">Trabajo Publicado</th>
                            <th scope="col">Expositor</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for=" reunion  in  reuniones " :key="reunion.id">
                            <td>{{ reunion.nombre }}</td>
                            <td>{{ reunion.fecha_inicio }}</td>
                            <td>{{ reunion.nacional == 1 ? reunion.ciudad : reunion.pais }}</td>
                            <td>{{ reunion.trabajo_publicado.titulo }}</td>
                            <td>{{ reunion.expositor.nombre + " " + reunion.expositor.apellido }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(reunion.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarReunion(reunion.id)"></button>
                                <button class="bi bi-trash btn"
                                    @click="mostrarModalEliminar(reunion.id, reunion.nombre)"></button>
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
import { useReunionCientificaStore } from '@/stores/reunion-cientifica';
import { createRouterMatcher, useRouter } from 'vue-router';

const router = useRouter();

const verDetalles = (reunionId) => {
    router.push("/reunion-cientifica/" + reunionId);
};
const editarReunion = (reunionId) => {
    router.push("/reunion-cientifica/" + reunionId + "/editar");
}
</script>
    
<script>
export default {
    async mounted() {
        const reunionStore = useReunionCientificaStore();
        await reunionStore.listarReuniones()
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 200) {
                    this.reuniones = data.data
                    this.loading = false;
                }
            })
        this.reunionStore = reunionStore;
    },
    data() {
        return {
            loading: true,
            reuniones: null,
            modalEliminar: {
                mostrar: false,
                id: 0,
                nombre: undefined,
                loading: false
            },
            exitoEliminar: false,
            reunionId: undefined,
        }
    },
    methods: {
        async eliminarReunion(reunionId) {
            this.modalEliminar.loading = true;
            await this.reunionStore.eliminarReunion(reunionId)
                .catch(e => console.error(e))
                .then(data => {
                    if (data.status == 200) {
                        this.exitoEliminar = true;
                        this.reuniones = this.reuniones.filter((reunion) => reunion.id != reunionId);
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
