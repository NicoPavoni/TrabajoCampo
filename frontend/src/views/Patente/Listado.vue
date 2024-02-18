<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Patentes</h2>

        <div class="modal" :class="{ 'd-block': modalEliminar.mostrar }" style="background-color: rgba(0,0,0,0.3)"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar patente</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="cerrarModalEliminar()"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea eliminar la patente '{{ modalEliminar.nombre }}'?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalEliminar()">Cerrar</button>
                        <button type="button" class="btn btn-danger" @click="eliminarPatente(modalEliminar.id)"
                            :disabled="modalEliminar.loading"><span class="spinner-border spinner-border-sm me-1"
                                role="status" aria-hidden="true" v-if="modalEliminar.loading"></span>Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container" v-if="!loading">
            <div class="d-flex align-items-center mt-4">
                <router-link to="/patente/alta" class="text-center btn btn-success"><i
                        class="bi bi-plus-lg me-2"></i>Nuevo</router-link>

                <div class="alert alert-success mx-auto p-2" v-if="exitoEliminar">Patente '{{ modalEliminar.nombre
                }}' eliminada exitosamente
                </div>
            </div>

            <div class="overflow-auto mb-4 mt-3">
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Titulo </th>
                            <th scope="col">Fecha de Presentación</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for=" patente  in  patentes " :key="patente.id">
                            <td>{{ patente.titulo }}</td>
                            <td>{{ patente.fecha_presentacion }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(patente.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarPatente(patente.id)"></button>
                                <button class="bi bi-trash btn"
                                    @click="mostrarModalEliminar(patente.id, patente.titulo)"></button>
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
import { usePatenteStore } from '@/stores/patente';
import { createRouterMatcher, useRouter } from 'vue-router';

const router = useRouter();

const verDetalles = (patenteId) => {
    router.push("/patente/" + patenteId);
};
const editarPatente = (patenteId) => {
    router.push("/patente/" + patenteId + "/editar");
}
</script>
    
<script>
export default {
    async mounted() {
        const patenteStore = usePatenteStore();
        await patenteStore.listarPatentes()
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 200) {
                    this.patentes = data.data
                    this.loading = false;
                }
            })
        this.patenteStore = patenteStore;
    },
    data() {
        return {
            loading: true,
            patentes: null,
            modalEliminar: {
                mostrar: false,
                id: 0,
                nombre: undefined,
                loading: false
            },
            exitoEliminar: false,
            patenteId: undefined,
        }
    },
    methods: {
        async eliminarPatente(patenteId) {
            this.modalEliminar.loading = true;
            await this.patenteStore.eliminarPatente(patenteId)
                .catch(e => console.error(e))
                .then(data => {
                    if (data.status == 200) {
                        this.exitoEliminar = true;
                        this.patentes = this.patentes.filter((patente) => patente.id != patenteId);
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
