<template>
  <DefaultLayout>
    <form @submit="crearEvento">
      <div class="container d-flex flex-column mt-5" v-if="!loadingAsistentes">
        <h2 class="text-center mb-4 center-content">Eventos - Alta</h2>

        <div class="d-flex flex-column  flex-md-row justify-content-center">
          <div class="mb-3 me-3">
            <label for="nombre" class="form-label fw-bold">Nombre del Evento</label>
            <input v-model="evento.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre" required>
          </div>

          <div class="mb-3 me-3">
            <label for="lugar" class="form-label fw-bold">Lugar</label>
            <input v-model="evento.lugar" type="text" class="form-control" id="lugar" placeholder="Lugar" required>
          </div>

          <div class="mb-3">
            <label for="fecha" class="form-label fw-bold">Fecha</label>
            <div class="input-group">
              <input v-model="evento.fecha" type="date" class="form-control" id="fecha" placeholder="Fecha" required>
            </div>
          </div>
        </div>

        <div class="mb-3 d-flex flex-column  align-items-center">
          <label class="form-label mb-2 fw-bold" for="descripcion">Descripción</label>

          <div class="d-flex justify-content-between justify-content-md-center">
            <textarea name="descripcion" id="descripcion" cols="63" rows="5" class="form-control"
              v-model="evento.descripcion"></textarea>
          </div>
        </div>

        <div class="d-flex flex-column align-items-center">
          <label class="form-label fw-bold mb-2">Asistentes</label>
          <div class="input-group input-autor">
            <select v-model="asistenteSeleccionado" class="form-control" aria-label="Buscar Asistentes">
              <option v-for="asistente in asistentesNoSeleccionados" :value="asistente.id" :key="asistente.id">{{
                asistente.nombre + " " +
                asistente.apellido }}
              </option>
            </select>
            <div class="input-group-append">
              <button @click="agregarAsistente" class="btn btn-success" type="button">
                <i class="bi bi-plus me-1 text-light"></i>Agregar
              </button>
            </div>
          </div>
        </div>

        <span v-if="errors.asistentes" class="small text-danger text-center my-2">{{ errors.asistentes }}</span>
        <!-- sección contenedora para centrar el input y la tabla -->
        <div class="overflow-auto mb-4 mt-3" v-if="evento.asistentes.length > 0">
          <!-- Tabla de Asistentes -->
          <table class="table mx-auto text-center">
            <thead>
              <tr>
                <th scope="col">Nombre del asistente</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="asistente in asistentesSeleccionados" :key="asistente.id">
                <td>{{ asistente.nombre + " " + asistente.apellido }}</td>
                <td class="">
                  <i @click="eliminarAsistente(asistente.id)" class="bi bi-trash"></i>
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
          <i class="bi bi-plus me-1" :class="{ 'd-none': loading }"></i>Crear Evento
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Evento creado exitosamente.
      Redireccionando al listado...
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { useEventoStore } from '@/stores/evento';
import { usePersonaStore } from '@/stores/persona';
import { useRouter } from 'vue-router';


</script>

<script>


export default {

  async mounted() {
    const eventoStore = useEventoStore();
    const personaStore = usePersonaStore();
    await personaStore.listarPersonas();
    this.loadingAsistentes = false;

    this.asistentes = personaStore.getPersonas;
    this.asistentesNoSeleccionados = this.asistentes;

    this.eventoStore = eventoStore;
  },

  data() {
    return {
      "errors": {
        "asistentes": null
      },
      "evento": {
        "nombre": null,
        "lugar": null,
        "fecha": null,
        "descripcion": null,
        "asistentes": []
      },
      "asistentes": [],
      "asistentesNoSeleccionados": [],
      "asistenteSeleccionado": null,
      "mensajeExito": null,
      "loadingAsistentes": true,
      "loading": false
    }
  },
  computed: {
    asistentesSeleccionados() {
      return this.asistentes.filter((asistente) => this.evento.asistentes.includes(asistente.id))
    }
  },

  methods: {
    crearEvento: async function (e) {
      e.preventDefault();
      this.errors = {
        "asistentes": null
      }

      if (this.evento.asistentes.length <= 0) {
        this.errors.asistentes = "Por favor ingrese por lo menos un asistente";
      }

      if (this.errors.asistentes !== null) {
        return;
      }
      this.loading = true;
      await this.eventoStore.crearEvento(this.evento)
        .catch(e => console.error(e))
        .then(data => {
          this.loading = false;
          if (data.status == 201) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoEvento' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoEvento' });
    },

    agregarAsistente: function () {
      if (!this.asistenteSeleccionado) {
        return;
      }
      this.evento.asistentes.push(this.asistenteSeleccionado);
      this.asistenteSeleccionado = null;
      this.asistentesNoSeleccionados = this.asistentes.filter((asistente) => !this.evento.asistentes.includes(asistente.id))
    },

    eliminarAsistente: function (asistente_id) {
      let asistenteIndex = this.evento.asistentes.indexOf(asistente_id);
      this.evento.asistentes.splice(asistenteIndex, 1);
      this.asistentesNoSeleccionados = this.asistentes.filter((asistente) => !this.evento.asistentes.includes(asistente.id))
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