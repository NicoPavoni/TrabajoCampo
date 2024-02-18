<template>
  <DefaultLayout>
    <form @submit="crearRegistro">
      <div class="container d-flex flex-column mt-5" v-if="!loadingTitulares">
        <h2 class="text-center mb-4 center-content">Registro de Propiedad Intelectual - Alta</h2>

        <div class="d-flex flex-column gap-3 flex-md-row justify-content-center">
          <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">Nombre</label>
            <input v-model="registro.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre" required>
          </div>
          <div class="mb-3">
            <label for="titular" class="form-label fw-bold">Titular</label>
            <select name="titular" id="titular" class="form-control" v-model="registro.titular_id">
              <option value="" selected disabled>Seleccione un titular</option>
              <option v-for="titular in titulares" :key="titular.id" :value="titular.id">{{
                titular.nombre + " " + titular.apellido }}
              </option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tipo_licencia" class="form-label fw-bold">Tipo de Licencia</label>
            <select name="tipo_licencia" id="tipo_licencia" class="form-control" v-model="registro.tipo_licencia_id">
              <option value="" selected disabled>Seleccione una licencia</option>
              <option v-for="tipo in tipos_licencia" :key="tipo.id" :value="tipo.id">{{ tipo.nombre }}
              </option>
            </select>
          </div>
        </div>

      </div>
      <div class="align-self-center p-5 mx-auto center-content" v-else>
        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <!-- Botones -->
      <div class="d-flex justify-content-center  mb-5 mt-3">
        <button @click="cancelar" type="button" class="btn btn-danger me-3">
          <i class="bi bi-x me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-success" :disabled="loading">
          <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" v-if="loading"></span>
          <i class="bi bi-plus me-1" :class="{ 'd-none': loading }"></i>Crear Registro
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Registro creado exitosamente.
      Redireccionando al listado...
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { useRegPropIntelectualStore } from '@/stores/registro-propiedad-intelectual';
import { usePersonaStore } from '@/stores/persona';
import { useParametricaStore } from '@/stores/parametricas';
import { useRouter } from 'vue-router';


</script>

<script>


export default {

  async mounted() {
    const registroStore = useRegPropIntelectualStore();
    const personaStore = usePersonaStore();
    await personaStore.listarPersonas();
    const parametricaStore = useParametricaStore();
    await parametricaStore.listarTiposLicencia().then(data => {
      this.tipos_licencia = data.data;
    });
    this.loadingTitulares = false;

    this.titulares = personaStore.getPersonas;
    this.titularesNoSeleccionados = this.titulares;

    this.registroStore = registroStore;
  },

  data() {
    return {
      "registro": {
        "nombre": null,
        "titular_id": undefined,
        "tipo_licencia_id": undefined,
      },
      "tipos_licencia": [],
      "titulares": [],
      "mensajeExito": null,
      "loadingTitulares": true,
      "loading": false
    }
  },

  methods: {
    crearRegistro: async function (e) {
      e.preventDefault();
      this.loading = true;
      await this.registroStore.crearRegPropIntelectual(this.registro)
        .catch(e => console.error(e))
        .then(data => {
          this.loading = false;
          if (data.status == 201) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoRegPropIntelectual' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoRegPropIntelectual' });
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