<template>
    <DefaultLayout>
        <div class="container d-flex flex-column mt-5" v-if="!loading">
            <h2 class="text-center mb-4 center-content">Publicaciónes en Revistas Nacionales - Detalle</h2>

            <div class="d-flex flex-column gap-3 flex-md-row justify-content-center">
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Nombre de la Publicación</label>
                    <input v-model="revista.nombre" type="text" class="form-control" id="nombre" disabled>
                </div>

                <div class="mb-3">
                    <label for="pais" class="form-label fw-bold">Pais</label>
                    <input v-model="revista.pais" type="text" class="form-control" id="pais" disabled>
                </div>

                <div class="mb-3">
                    <label for="editorial" class="form-label fw-bold">Editorial</label>
                    <div class="input-group">
                        <input v-model="revista.editorial" type="text" class="form-control" id="editorial" disabled>
                    </div>
                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row justify-content-center gap-3 align-items-center">
                <div class="mb-3">
                    <label for="issn" class="form-label fw-bold">ISSN</label>
                    <div class="input-group">
                        <input v-model="revista.issn" type="text" class="form-control" id="issn" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="trabajo_publicado" class="form-label fw-bold">Trabajo Publicado</label>
                    <div class="input-group">
                        <select v-model="revista.trabajo_id" class="form-control" aria-label="Buscar Autores"
                            id="trabajo_publicado">
                            <option v-for="trabajo in trabajosPublicados" :value="trabajo.id" :key="trabajo.id">{{
                                trabajo.titulo }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 d-flex gap-2 mt-5">
                    <p class="text-success" v-if="revista.con_referato">Con referato</p>
                    <p class="text-danger" v-else>Sin referato</p>
                </div>
            </div>

            <!-- sección contenedora para centrar el input y la tabla -->
            <div class="overflow-auto mb-4 mt-3" v-if="revista.autores.length > 0">
                <!-- Tabla de Autores -->
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="autor in revista.autores" :key="autor.id">
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
import { useDocumentoStore } from '@/stores/documento';
import { useParametricaStore } from '@/stores/parametricas';
import { useRouter } from 'vue-router';
</script>
  
<script>


export default {

    async mounted() {
        const parametricaStore = useParametricaStore();
        await parametricaStore.listarTrabajosPublicados().then(data => this.trabajosPublicados = data.data)
        const docStore = useDocumentoStore();
        await docStore.detalleDocumento(this.$route.params.id)
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 401) {
                    localStorage.clear();
                    this.$router.push({ name: "login" })
                } else if (data.status == 200) {
                    if (!data.data.hasOwnProperty('revista_nacional')) {
                        this.mensajeError = "Error en el detalle: Este documento no es una Publicación en Revistas Nacionales"
                    }
                    this.revista.nombre = data.data.nombre;
                    this.revista.pais = data.data.revista_nacional.pais;
                    this.revista.editorial = data.data.revista_nacional.editorial;
                    this.revista.trabajo_id = data.data.revista_nacional.trabajo_id;
                    this.revista.issn = data.data.revista_nacional.issn;
                    this.revista.titulo_trabajo = data.data.revista_nacional.titulo_trabajo;
                    this.revista.con_referato = data.data.revista_nacional.con_referato;
                    this.revista.autores = data.data.autores;
                    this.loadingAutores = false;
                    this.loading = false;
                }
            })

    },

    data() {
        return {
            "revista": {
                "nombre": null,
                "pais": null,
                "editorial": null,
                "issn": null,
                "trabajo_id": null,
                "con_referato": null,
                "autores": []
            },
            "trabajosPublicados": [],
            "loading": true
        }
    },

    methods: {

        volver: function () {
            this.$router.push({ name: 'listadoRevistaNacional' });
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
  