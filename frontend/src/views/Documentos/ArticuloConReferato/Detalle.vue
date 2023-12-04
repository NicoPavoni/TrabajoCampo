<template>
    <DefaultLayout>
        <form @submit="editarArticulo">
            <div class="container d-flex flex-column mt-5">
                <h2 class="text-center mb-4 center-content">Articulos con Referato - Alta</h2>

                <div class="d-flex flex-column  flex-md-row justify-content-center">
                    <div class="mb-3 me-3">
                        <label for="nombreArticulo" class="form-label fw-bold">Nombre del Articulo</label>
                        <input v-model="articulo.nombre" type="text" class="form-control" id="nombreArticulo"
                            placeholder="Nombre" required disabled>
                    </div>

                    <div class="mb-3 me-3">
                        <label for="lugar" class="form-label fw-bold">Lugar</label>
                        <input v-model="articulo.articulo_con_referato.lugar" type="text" class="form-control" id="lugar"
                            placeholder="Lugar" required disabled>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label fw-bold">Fecha</label>
                        <div class="input-group">
                            <input v-model="articulo.articulo_con_referato.fecha" type="date" class="form-control"
                                id="fecha" placeholder="Fecha" required disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex flex-column  align-items-center">
                    <label class="form-label mb-2 fw-bold">Tipo de Congreso</label>

                    <div class="d-flex w-100 justify-content-between justify-content-md-center">
                        {{ articulo.articulo_con_referato.es_nacional ? 'Nacional 🇦🇷' : 'Internacional 🌎' }}
                    </div>
                </div>

                <!-- sección contenedora para centrar el input y la tabla -->
                <div class="overflow-auto mb-4 mt-3" v-if="articulo.autores.length > 0">
                    <!-- Tabla de Autores -->
                    <table class="table mx-auto text-center">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="autor in articulo.autores" :key="autor.id">
                                <td>{{ autor.nombre }}</td>
                                <td>
                                    {{ autor.apellido }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-center  mb-5 mt-3">
                <button @click="volver" type="button" class="btn btn-secondary me-3">
                    <i class="bi bi-arrow-left me-1"></i>Volver al listado
                </button>
            </div>
        </form>

        <div class="alert alert-success align-self-center" v-if="mensajeExito">Articulo con Referato actualizado
            exitosamente
        </div>
        <div class="alert alert-danger align-self-center" v-if="mensajeError">{{ mensajeError }}</div>
    </DefaultLayout>
</template>
  
<script setup>
import DefaultLayout from '../../../layouts/DefaultLayout.vue';
import { useArtReferatoStore } from '@/stores/articulo-con-referato';
import { useRouter } from 'vue-router';
</script>
  
<script>


export default {

    async mounted() {
        const artStore = useArtReferatoStore();
        await artStore.detalleArtReferato(this.$route.params.id)
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 401) {
                    localStorage.clear();
                    this.$router.push({ name: "login" })
                } else if (data.status == 200) {
                    if (!data.data.hasOwnProperty('articulo_con_referato')) {
                        this.mensajeError = "Error en el detalle: Este documento no es un Articulo con Referato"
                    }
                    this.articulo = data.data;
                }
            })

    },

    data() {
        return {
            "articulo": {
                "nombre": null,
                "articulo_con_referato": {
                    "lugar": null,
                    "fecha": null,
                    "es_nacional": null,
                },
                "autores": []
            },
        }
    },

    methods: {

        volver: function () {
            this.$router.push({ name: 'listadoArtReferato' });
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
  