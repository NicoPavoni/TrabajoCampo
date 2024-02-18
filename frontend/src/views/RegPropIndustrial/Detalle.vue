<template>
    <DefaultLayout>
        <div class="container d-flex flex-column mt-5" v-if="!loading">
            <h2 class="text-center mb-4 center-content">Registro de Propiedad Industrial - Detalle</h2>

            <div class="d-flex flex-column gap-3 flex-md-row justify-content-center">
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Nombre</label>
                    <input v-model="registro.nombre" type="text" class="form-control" id="nombre" disabled>
                </div>
                <div class="mb-3">
                    <label for="titular" class="form-label fw-bold">Titular</label>
                    <input v-model="registro.titular" type="text" class="form-control" id="titular" disabled>

                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label fw-bold">Tipo</label>
                    <input v-model="registro.tipo" type="text" class="form-control" id="tipo" disabled>
                </div>

            </div>
            <div class="d-flex flex-column gap-3 flex-md-row justify-content-center">
                <div class="mb-3">
                    <label for="disenios_y_modelos" class="form-label fw-bold">Diseños y modelos</label>
                    <textarea v-model="registro.disenios_y_modelos" class="form-control" id="disenios_y_modelos" cols="60"
                        rows="3" disabled></textarea>
                </div>
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
import { useRegPropIndustrialStore } from '@/stores/registro-propiedad-industrial';
import { useRouter } from 'vue-router';
</script>
  
<script>


export default {

    async mounted() {
        const registroStore = useRegPropIndustrialStore();
        await registroStore.detalleRegPropIndustrial(this.$route.params.id)
            .catch(e => console.error(e))
            .then(data => {
                if (data.status == 401) {
                    localStorage.clear();
                    this.$router.push({ name: "login" })
                } else if (data.status == 200) {
                    this.registro.nombre = data.data.nombre;
                    this.registro.titular = data.data.titular.nombre + " " + data.data.titular.apellido;
                    this.registro.tipo = data.data.tipo;
                    this.registro.disenios_y_modelos = data.data.disenios_y_modelos;
                    this.loading = false;
                }
            })

    },

    data() {
        return {
            "registro": {
                "nombre": null,
                "tipo": null,
                "titular": null,
                "disenios_y_modelos": null,
            },
            "loading": true
        }
    },

    methods: {

        volver: function () {
            this.$router.push({ name: 'listadoRegPropIndustrial' });
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
  