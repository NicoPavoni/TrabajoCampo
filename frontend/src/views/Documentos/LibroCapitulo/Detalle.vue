<template>
    <DefaultLayout>
        <div class="container d-flex flex-column mt-5" v-if="!loading">
            <h2 class="text-center mb-4 center-content">Libros y Capitulos - Detalle</h2>

            <div class="d-flex flex-column  flex-md-row justify-content-center">
                <div class="mb-3 me-3">
                    <label for="nombreLibroCapitulo" class="form-label fw-bold">Nombre del Libro/Capitulo</label>
                    <input v-model="libroCapitulo.nombre" type="text" class="form-control" id="nombreLibroCapitulo"
                        placeholder="Nombre" disabled>
                </div>

                <div class="mb-3 me-3">
                    <label for="isbn" class="form-label fw-bold">ISBN</label>
                    <input v-model="libroCapitulo.isbn" type="text" class="form-control" id="isbn" placeholder="ISBN"
                        disabled>
                </div>

                <div class="mb-3">
                    <label for="editorial" class="form-label fw-bold">Editorial</label>
                    <input v-model="libroCapitulo.editorial" type="text" class="form-control" id="editorial"
                        placeholder="Editorial" disabled>
                </div>
            </div>

            <div class="mb-3 d-flex flex-column  align-items-center">
                <div class="mb-3 me-3">
                    <label for="nro_capitulo" class="form-label fw-bold">N° Capitulo</label>
                    <input v-model="libroCapitulo.nro_capitulo" type="number" class="form-control" id="nro_capitulo"
                        placeholder="Opcional" disabled>
                </div>
            </div>

            <!-- sección contenedora para centrar el input y la tabla -->
            <div class="overflow-auto mb-4 mt-3" v-if="libroCapitulo.autores.length > 0">
                <!-- Tabla de Autores -->
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="autor in libroCapitulo.autores" :key="autor.id">
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
import DefaultLayout from '../../../layouts/DefaultLayout.vue';
import { useDocumentoStore } from '@/stores/documento';
import { useRouter } from 'vue-router';
</script>
  
<script>


export default {

    async mounted() {
        const docStore = useDocumentoStore();
        await docStore.detalleDocumento(this.$route.params.id)
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 401) {
                    localStorage.clear();
                    this.$router.push({ name: "login" })
                } else if (data.status == 200) {
                    if (!data.data.hasOwnProperty('libro_capitulo')) {
                        this.mensajeError = "Error en el detalle: Este documento no es un Libro/Capitulo"
                    }
                    this.libroCapitulo = data.data;
                    this.loading = false;
                }
            })

    },

    data() {
        return {
            "libroCapitulo": {
                "nombre": null,
                "libro_capitulo": {
                    "isbn": null,
                    "editorial": null,
                    "nro_capitulo": null,
                },
                "autores": []
            },
            "loading": true
        }
    },

    methods: {

        volver: function () {
            this.$router.push({ name: 'listadoLibroCapitulo' });
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
  