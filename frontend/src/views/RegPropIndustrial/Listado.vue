<template>
    <DefaultLayout>

        <h2 class="text-center mt-3">Listado de Registros de Propiedad Industriales</h2>

        <div class="modal" :class="{ 'd-block': modalEliminar.mostrar }" style="background-color: rgba(0,0,0,0.3)"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar registro de propiedad industrial</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="cerrarModalEliminar()"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea eliminar el registro '{{ modalEliminar.nombre }}'?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalEliminar()">Cerrar</button>
                        <button type="button" class="btn btn-danger" @click="eliminarRegistro(modalEliminar.id)"
                            :disabled="modalEliminar.loading"><span class="spinner-border spinner-border-sm me-1"
                                role="status" aria-hidden="true" v-if="modalEliminar.loading"></span>Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container" v-if="!loading">
            <div class="d-flex align-items-center mt-4">
                <router-link to="/registro-propiedad-industrial/alta" class="text-center btn btn-success"><i
                        class="bi bi-plus-lg me-2"></i>Nuevo</router-link>

                <div class="alert alert-success mx-auto p-2" v-if="exitoEliminar">Registro de Propiedad Industrial '{{
                    modalEliminar.nombre
                }}' eliminado exitosamente
                </div>
            </div>

            <div class="overflow-auto mb-4 mt-3">
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre </th>
                            <th scope="col">Titular</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for=" registro  in  registros " :key="registro.id">
                            <td>{{ registro.nombre }}</td>
                            <td>{{ registro.titular.nombre + " " + registro.titular.apellido }}</td>
                            <td>{{ registro.tipo }}</td>
                            <td><button class="bi bi-eye btn" @click="verDetalles(registro.id)"></button>
                                <button class="bi bi-pencil btn" @click="editarRegistro(registro.id)"></button>
                                <button class="bi bi-trash btn"
                                    @click="mostrarModalEliminar(registro.id, registro.nombre)"></button>
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
import { useRegPropIndustrialStore } from '@/stores/registro-propiedad-industrial';
import { createRouterMatcher, useRouter } from 'vue-router';

const router = useRouter();

const verDetalles = (registroId) => {
    router.push("/registro-propiedad-industrial/" + registroId);
};
const editarRegistro = (registroId) => {
    router.push("/registro-propiedad-industrial/" + registroId + "/editar");
}
</script>
    
<script>
export default {
    async mounted() {
        const registroStore = useRegPropIndustrialStore();
        await registroStore.listarRegPropIndustriales()
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 200) {
                    this.registros = data.data
                    this.loading = false;
                }
            })
        this.registroStore = registroStore;
    },
    data() {
        return {
            loading: true,
            registros: null,
            modalEliminar: {
                mostrar: false,
                id: 0,
                nombre: undefined,
                loading: false
            },
            exitoEliminar: false,
            registroId: undefined,
        }
    },
    methods: {
        async eliminarRegistro(registroId) {
            this.modalEliminar.loading = true;
            await this.registroStore.eliminarRegPropIndustrial(registroId)
                .catch(e => console.error(e))
                .then(data => {
                    if (data.status == 200) {
                        this.exitoEliminar = true;
                        this.registros = this.registros.filter((registro) => registro.id != registroId);
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
