<template>
    <DefaultLayout>
        <div class="container d-flex flex-column mt-5" v-if="!loading">
            <h2 class="text-center mb-4 center-content">Patentes - Detalle</h2>

            <div class="d-flex flex-column  flex-md-row justify-content-center">
                <div class="mb-3 me-3">
                    <label for="nombre" class="form-label fw-bold">Titulo</label>
                    <input v-model="patente.titulo" type="text" class="form-control" id="nombre" disabled>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label fw-bold">Fecha de Presentación</label>
                    <div class="input-group">
                        <input v-model="patente.fecha_presentacion" type="date" class="form-control" id="fecha" disabled>
                    </div>
                </div>
            </div>

            <!-- sección contenedora para centrar el input y la tabla -->
            <div class="overflow-auto mb-4 mt-3" v-if="patente.titulares.length > 0">
                <!-- Tabla de Titulares -->
                <table class="table mx-auto text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="titular in patente.titulares" :key="titular.id">
                            <td>{{ titular.nombre }}</td>
                            <td>{{ titular.apellido }}</td>
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
import { usePatenteStore } from '@/stores/patente';
import { useRouter } from 'vue-router';
</script>
  
<script>


export default {

    async mounted() {
        const patenteStore = usePatenteStore();
        await patenteStore.detallePatente(this.$route.params.id)
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 401) {
                    localStorage.clear();
                    this.$router.push({ name: "login" })
                } else if (data.status == 200) {
                    this.patente = data.data;
                    this.loading = false;
                }
            })

    },

    data() {
        return {
            "patente": {
                "titulo": null,
                "fecha_presentacion": null,
                "titulares": []
            },
            "loading": true
        }
    },

    methods: {

        volver: function () {
            this.$router.push({ name: 'listadoPatente' });
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
  