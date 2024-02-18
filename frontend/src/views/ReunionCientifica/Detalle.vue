<template>
    <DefaultLayout>
        <div class="container d-flex flex-column mt-5" v-if="!loading">
            <h2 class="text-center mb-4 center-content">Reunión Científica - Detalle</h2>

            <div class="d-flex flex-column  flex-md-row justify-content-center gap-4">
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Nombre de la Reunión</label>
                    <input v-model="reunion.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre"
                        disabled>
                </div>

                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label fw-bold">Fecha de Inicio</label>
                    <input v-model="reunion.fecha_inicio" type="date" class="form-control" id="fecha_inicio" disabled>
                </div>

                <div class="mb-3">
                    <label for="trabajo_publicado" class="form-label fw-bold">Trabajo Publicado</label>
                    <select v-model="reunion.trabajo_id" id="trabajo_publicado" class="form-control" disabled>
                        <option value="" selected disabled>Seleccione un trabajo</option>
                        <option v-for="trabajo in trabajosPublicados" :key="trabajo.id" :value="trabajo.id">{{
                            trabajo.titulo }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
                <div class="d-flex gap-2 mt-3">
                    <span v-if="reunion.nacional">Nacional 🇦🇷</span>
                    <span v-else>Internacional 🌎</span>
                </div>
                <div class="mb-3" v-if="reunion.nacional">
                    <label for="ciudad" class="form-label fw-bold">Ciudad</label>
                    <input v-model="reunion.ciudad" type="text" class="form-control" id="ciudad" placeholder="Ciudad"
                        disabled>
                </div>
                <div class="mb-3" v-else>
                    <label for="pais" class="form-label fw-bold">País</label>
                    <input v-model="reunion.pais" type="text" class="form-control" id="pais" placeholder="País" disabled>
                </div>

                <div class="mb-3">
                    <label for="expositor" class="form-label fw-bold">Expositor</label>
                    <select v-model="reunion.expositor_id" id="expositor" class="form-control" disabled>
                        <option value="" selected disabled>Seleccione un expositor</option>
                        <option v-for="persona in autores" :key="persona.id" :value="persona.id">{{ persona.nombre + " " +
                            persona.apellido }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- sección contenedora para centrar el input y la tabla -->
            <div class="overflow-auto mb-4 mt-3" v-if="reunion.autores.length > 0">
                <!-- Tabla de Autores -->
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="autor in reunion.autores" :key="autor.id">
                            <td>{{ autor.nombre }}</td>
                            <td>
                                {{ autor.apellido }}
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
        <!-- Botones -->
        <div class="d-flex justify-content-center  mb-5 mt-3">
            <button @click="volver" type="button" class="btn btn-secondary me-3">
                <i class="bi bi-arrow-left me-1"></i>Volver al listado
            </button>
        </div>
        <div class="alert alert-danger align-self-center" v-if="mensajeError">{{ mensajeError }}</div>
    </DefaultLayout>
</template>
  
<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { useReunionCientificaStore } from '@/stores/reunion-cientifica';
import { useParametricaStore } from '@/stores/parametricas';
import { usePersonaStore } from '@/stores/persona';
import { useRouter } from 'vue-router';
</script>
  
<script>


export default {

    async mounted() {
        const personaStore = usePersonaStore();
        await personaStore.listarPersonas();

        this.autores = personaStore.getPersonas;
        this.autoresNoSeleccionados = this.autores;

        const parametricaStore = useParametricaStore();
        await parametricaStore.listarTrabajosPublicados().then(data => this.trabajosPublicados = data.data);
        const reunionStore = useReunionCientificaStore();
        await reunionStore.detalleReunion(this.$route.params.id)
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 401) {
                    localStorage.clear();
                    this.$router.push({ name: "login" })
                } else if (data.status == 200) {
                    this.reunion = data.data;
                    this.loading = false;
                }
            })

    },

    data() {
        return {
            "reunion": {
                "nombre": null,
                "fecha_inicio": null,
                "trabajo_id": null,
                "ciudad": null,
                "pais": null,
                "nacional": false,
                "expositor_id": null,
                "autores": []
            },
            "trabajosPublicados": [],
            "loading": true
        }
    },

    methods: {

        volver: function () {
            this.$router.push({ name: 'listadoReunionCientifica' });
        },
    }
}
</script>
  
<style scoped>
.center-content {
    width: 100%;
    text-align: center;
}

/* Estilo para reducir tamaño y color de los íconos de búsqueda y flecha */
.input-group-append .btn-success i {
    font-size: 1rem;
    color: black;
}

/* Añade espacio entre los radio button */
.form-check {
    margin-right: 4rem;
}

/* estilo del botón hamburguer */
.btn-primary {
    background-color: transparent;
    border: none;
    color: black;
}

.btn-primary:hover {
    background-color: transparent;
    border: none;
    color: black;
}

/* estilos de los botones de acciones en la tabla */
.table i {
    color: black;
    font-size: 1.2rem;
    cursor: pointer;
    margin-right: 5px;
}

@media(min-width:768px) {
    .input-autor {
        max-width: 400px;
    }

    .table {
        max-width: 600px;
        max-height: 400px;
    }
}
</style>
  