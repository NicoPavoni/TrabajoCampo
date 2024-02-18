<template>
  <DefaultLayout>
    <form @submit="editarPatente">
      <div class="container d-flex flex-column mt-5" v-if="!loadingTitulares">
        <h2 class="text-center mb-4 center-content">Patentes - Editar</h2>

        <div class="d-flex flex-column  flex-md-row justify-content-center">
          <div class="mb-3 me-3">
            <label for="nombre" class="form-label fw-bold">Titulo</label>
            <input v-model="patente.titulo" type="text" class="form-control" id="nombre" placeholder="Nombre" required>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label fw-bold">Fecha de Presentación</label>
            <div class="input-group">
              <input v-model="patente.fecha_presentacion" type="date" class="form-control" id="fecha" placeholder="Fecha"
                required>
            </div>
          </div>
        </div>

        <div class="d-flex flex-column align-items-center">
          <label class="form-label fw-bold mb-2">Titulares</label>
          <div class="input-group input-autor">
            <select v-model="titularSeleccionado" class="form-control" aria-label="Buscar Titulares">
              <option v-for="titular in titularesNoSeleccionados" :value="titular.id" :key="titular.id">{{
                titular.nombre + " " +
                titular.apellido }}
              </option>
            </select>
            <div class="input-group-append">
              <button @click="agregarAsistente" class="btn btn-success" type="button">
                <i class="bi bi-plus me-1 text-light"></i>Agregar
              </button>
            </div>
          </div>
        </div>

        <span v-if="errors.titulares" class="small text-danger text-center my-2">{{ errors.titulares }}</span>
        <!-- sección contenedora para centrar el input y la tabla -->
        <div class="overflow-auto mb-4 mt-3" v-if="patente.titulares.length > 0">
          <!-- Tabla de Titulares -->
          <table class="table mx-auto text-center">
            <thead>
              <tr>
                <th scope="col">Nombre del titular</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="titular in titularesSeleccionados" :key="titular.id">
                <td>{{ titular.nombre + " " + titular.apellido }}</td>
                <td class="">
                  <i @click="eliminarAsistente(titular.id)" class="bi bi-trash"></i>
                </td>
              </tr>
            </tbody>
          </table>
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
          <i class="bi bi-plus me-1" :class="{ 'd-none': loading }"></i>Editar Patente
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Patente actualizado exitosamente.
      Redireccionando al listado...
    </div>
    <div class="alert alert-danger align-self-center" v-if="mensajeError">{{ mensajeError }}</div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { usePatenteStore } from '@/stores/patente';
import { usePersonaStore } from '@/stores/persona';
import { useRouter } from 'vue-router';
</script>

<script>


export default {

  async mounted() {
    const patenteStore = usePatenteStore();
    const personaStore = usePersonaStore();

    await personaStore.listarPersonas();
    this.mensajeError = null;
    await patenteStore.detallePatente(this.$route.params.id)
      .catch(e => console.error(e))
      .then(data => {
        if (data.status == 401) {
          localStorage.clear();
          this.$router.push({ name: "login" })
        } else if (data.status == 200) {
          this.patente.titulo = data.data.titulo;
          this.patente.fecha_presentacion = data.data.fecha_presentacion;
          let titulares = data.data.titulares.map(titular => titular.id)
          this.patente.titulares = titulares;
          this.loadingTitulares = false;
          this.loading = false;
        }
      })

    this.titulares = personaStore.getPersonas;
    this.titularesNoSeleccionados = this.titulares.filter((titular) => !this.patente.titulares.includes(titular.id))

    this.patenteStore = patenteStore;

  },

  data() {
    return {
      "errors": {
        "titulares": null
      },
      "patente": {
        "titulo": null,
        "fecha_presentacion": null,
        "titulares": []
      },
      "titulares": [],
      "titularesNoSeleccionados": [],
      "titularSeleccionado": null,
      "mensajeExito": null,
      "mensajeError": null,
      loadingTitulares: true,
      "loading": true
    }
  },
  computed: {
    titularesSeleccionados() {
      return this.titulares.filter((titular) => this.patente.titulares.includes(titular.id))
    }
  },

  methods: {
    editarPatente: async function (e) {
      e.preventDefault();

      this.errors = {
        "titulares": null
      }

      if (this.patente.titulares.length <= 0) {
        this.errors.titulares = "Por favor ingrese por lo menos un titular";
      }

      if (this.errors.titulares !== null) {
        return;
      }

      this.loading = true;
      await this.patenteStore.editarPatente(this.$route.params.id, this.patente)
        .catch(e => console.error(e))
        .then(data => {
          this.loading = false;
          if (data.status == 200) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoPatente' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoPatente' });
    },

    agregarAsistente: function () {
      if (!this.titularSeleccionado) {
        return;
      }
      this.patente.titulares.push(this.titularSeleccionado);
      this.titularSeleccionado = null;
      this.titularesNoSeleccionados = this.titulares.filter((titular) => !this.patente.titulares.includes(titular.id))
    },

    eliminarAsistente: function (titular_id) {
      let titularIndex = this.patente.titulares.indexOf(titular_id);
      this.patente.titulares.splice(titularIndex, 1);
      this.titularesNoSeleccionados = this.titulares.filter((titular) => !this.patente.titulares.includes(titular.id))
    }
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
