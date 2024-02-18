<template>
  <DefaultLayout>
    <form @submit="crearRevistaNacional">
      <div class="container d-flex flex-column mt-5" v-if="!loadingAutores">
        <h2 class="text-center mb-4 center-content">Publicaciónes en Revistas Nacionales - Alta</h2>

        <div class="d-flex flex-column gap-3 flex-md-row justify-content-center">
          <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">Nombre de la Publicación</label>
            <input v-model="revista.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre" required>
          </div>

          <div class="mb-3">
            <label for="pais" class="form-label fw-bold">Pais</label>
            <input v-model="revista.pais" type="text" class="form-control" id="pais" placeholder="Pais" required>
          </div>

          <div class="mb-3">
            <label for="editorial" class="form-label fw-bold">Editorial</label>
            <div class="input-group">
              <input v-model="revista.editorial" type="text" class="form-control" id="editorial" placeholder="Editorial"
                required>
            </div>
          </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row justify-content-center gap-3 align-items-center">
          <div class="mb-3">
            <label for="issn" class="form-label fw-bold">ISSN</label>
            <div class="input-group">
              <input v-model="revista.issn" type="text" class="form-control" id="issn" placeholder="ISSN" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="trabajo_publicado" class="form-label fw-bold">Trabajo Publicado</label>
            <div class="input-group">
              <select v-model="revista.trabajo_id" class="form-control" aria-label="Buscar Autores"
                id="trabajo_publicado">
                <option value="" selected disabled>Seleccione un trabajo</option>
                <option v-for="trabajo in trabajosPublicados" :value="trabajo.id" :key="trabajo.id">{{ trabajo.titulo }}
                </option>
              </select>
            </div>
          </div>
          <div class="mb-3 d-flex gap-2 mt-4">
            <input class="form-check-input" type="checkbox" v-model="revista.con_referato" id="conReferato">
            <label class="form-check-label" for="conReferato">
              Con referato
            </label>

          </div>
        </div>

        <div class="d-flex flex-column align-items-center">
          <label class="form-label fw-bold mb-2">Autores</label>
          <div class="input-group input-autor">
            <select v-model="autorSeleccionado" class="form-control" aria-label="Buscar Autores">
              <option v-for="autor in autoresNoSeleccionados" :value="autor.id" :key="autor.id">{{ autor.nombre + " " +
                autor.apellido }}
              </option>
            </select>
            <div class="input-group-append">
              <button @click="agregarAutor" class="btn btn-success" type="button">
                <i class="bi bi-plus me-1 text-light"></i>Agregar
              </button>
            </div>
          </div>
        </div>

        <span v-if="errors.autores" class="small text-danger text-center my-2">{{ errors.autores }}</span>
        <!-- sección contenedora para centrar el input y la tabla -->
        <div class="overflow-auto mb-4 mt-3" v-if="revista.autores.length > 0">
          <!-- Tabla de Autores -->
          <table class="table mx-auto text-center">
            <thead>
              <tr>
                <th scope="col">Nombre del autor</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="autor in autoresSeleccionados" :key="autor.id">
                <td>{{ autor.nombre + " " + autor.apellido }}</td>
                <td class="">
                  <!-- <i @click="verAutor(autor.id)" class="bi bi-eye"></i> -->
                  <i @click="eliminarAutor(autor.id)" class="bi bi-trash"></i>
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
          <i class="bi bi-plus me-1" :class="{ 'd-none': loading }"></i>Crear Publicación
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Publicación creada exitosamente.
      Redireccionando al listado...
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { useRevistaNacionalStore } from '@/stores/revista-nacional';
import { usePersonaStore } from '@/stores/persona';
import { useRouter } from 'vue-router';
import { useParametricaStore } from '@/stores/parametricas';

</script>

<script>


export default {

  async mounted() {
    const revistaNacionalStore = useRevistaNacionalStore();
    const parametricaStore = useParametricaStore();
    const personaStore = usePersonaStore();
    await personaStore.listarPersonas();
    await parametricaStore.listarTrabajosPublicados().then(data => this.trabajosPublicados = data.data)
    this.loadingAutores = false;



    this.autores = personaStore.getPersonas;
    this.autoresNoSeleccionados = this.autores;

    this.revistaNacionalStore = revistaNacionalStore;
  },

  data() {
    return {
      "errors": {
        "es_nacional": null,
        "autores": null
      },
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
      "autores": [],
      "autoresNoSeleccionados": [],
      "autorSeleccionado": null,
      "mensajeExito": null,
      "loadingAutores": true,
      "loading": false
    }
  },
  computed: {
    autoresSeleccionados() {
      return this.autores.filter((autor) => this.revista.autores.includes(autor.id))
    }
  },

  methods: {
    crearRevistaNacional: async function (e) {
      e.preventDefault();
      this.errors = {
        "es_nacional": null,
        "autores": null
      }

      if (this.revista.autores.length <= 0) {
        this.errors.autores = "Por favor ingrese un autor";
      }

      if (this.errors.autores !== null) {
        return;
      }
      this.loading = true;
      await this.revistaNacionalStore.crearRevistaNacional(this.revista)
        .catch(e => console.error(e))
        .then(data => {
          this.loading = false;
          if (data.status == 201) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoRevistaNacional' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoRevistaNacional' });
    },

    agregarAutor: function () {
      if (!this.autorSeleccionado) {
        return;
      }
      this.revista.autores.push(this.autorSeleccionado);
      this.autorSeleccionado = null;
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.revista.autores.includes(autor.id))
    },

    eliminarAutor: function (autor_id) {
      let autorIndex = this.revista.autores.indexOf(autor_id);
      this.revista.autores.splice(autorIndex, 1);
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.revista.autores.includes(autor.id))
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