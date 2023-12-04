<template>
  <DefaultLayout>
    <form @submit="editarArticulo">
      <div class="container d-flex flex-column mt-5">
        <h2 class="text-center mb-4 center-content">Articulos con Referato - Alta</h2>

        <div class="d-flex flex-column  flex-md-row justify-content-center">
          <div class="mb-3 me-3">
            <label for="nombreArticulo" class="form-label fw-bold">Nombre del Articulo</label>
            <input v-model="articulo.nombre" type="text" class="form-control" id="nombreArticulo" placeholder="Nombre"
              required>
          </div>

          <div class="mb-3 me-3">
            <label for="lugar" class="form-label fw-bold">Lugar</label>
            <input v-model="articulo.lugar" type="text" class="form-control" id="lugar" placeholder="Lugar" required>
          </div>

          <div class="mb-3">
            <label for="fecha" class="form-label fw-bold">Fecha</label>
            <div class="input-group">
              <input v-model="articulo.fecha" type="date" class="form-control" id="fecha" placeholder="Fecha" required>
            </div>
          </div>
        </div>

        <div class="mb-3 d-flex flex-column  align-items-center">
          <label class="form-label mb-2 fw-bold">Tipo de Congreso</label>

          <div class="d-flex w-100 justify-content-between justify-content-md-center">
            <div class="form-check">
              <input v-model="articulo.es_nacional" class="form-check-input" type="radio" id="nacional" value="1">
              <label class="form-check-label" for="nacional">Nacional</label>
            </div>
            <div class="form-check">
              <input v-model="articulo.es_nacional" class="form-check-input" type="radio" id="internacional" value="0">
              <label class="form-check-label" for="internacional">Internacional</label>
            </div>
          </div>
          <span v-if="errors.es_nacional" class="small text-danger">{{ errors.es_nacional }}</span>
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
        <div class="overflow-auto mb-4 mt-3" v-if="articulo.autores.length > 0">
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

      <!-- Botones -->
      <div class="d-flex justify-content-center  mb-5 mt-3">
        <button @click="cancelar" type="button" class="btn btn-danger me-3">
          <i class="bi bi-x me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-plus me-1"></i>Crear Articulo
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Articulo con Referato creado exitosamente</div>
    <div class="alert alert-success align-self-center" v-if="mensajeError">{{ mensajeError }}</div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '../../../layouts/DefaultLayout.vue';
import { useArtReferatoStore } from '@/stores/articulo-con-referato';
import { usePersonaStore } from '@/stores/persona';
import { useRouter } from 'vue-router';
</script>

<script>


export default {

  async mounted() {
    const artStore = useArtReferatoStore();
    const personaStore = usePersonaStore();

    await personaStore.listarPersonas();
    this.mensajeError = null;
    let articulo = await artStore.detalleArtReferato(this.$route.params.id)
      .catch(e => console.error(e))
      .then(data => {
        if (data.status == 401) {
          localStorage.clear();
          this.$router.push({ name: "login" })
        } else if (data.status == 200) {
          if (!data.data.hasOwnProperty('articulo_con_referato')) {
            this.mensajeError = "Error en el editar: Este documento no es un Articulo con Referato"
          }
          this.articulo.nombre = data.data.nombre;
          this.articulo.lugar = data.data.articulo_con_referato.lugar;
          this.articulo.fecha = data.data.articulo_con_referato.fecha;
          this.articulo.es_nacional = data.data.articulo_con_referato.es_nacional;
          let autores = data.data.autores.map(autor => autor.id)
          this.articulo.autores = autores;

        }
      })

    this.autores = personaStore.getPersonas;
    this.autoresNoSeleccionados = this.autores.filter((autor) => !this.articulo.autores.includes(autor.id))

    this.artStore = artStore;

  },

  data() {
    return {
      "errors": {
        "es_nacional": null,
        "autores": null
      },
      "articulo": {
        "nombre": null,
        "lugar": null,
        "fecha": null,
        "es_nacional": null,
        "autores": []
      },
      "autores": [],
      "autoresNoSeleccionados": [],
      "autorSeleccionado": null,
      "mensajeExito": null,
      "mensajeError": null
    }
  },
  computed: {
    autoresSeleccionados() {
      return this.autores.filter((autor) => this.articulo.autores.includes(autor.id))
    }
  },

  methods: {
    editarArticulo: async function (e) {
      e.preventDefault();

      this.errors = {
        "es_nacional": null,
        "autores": null
      }

      if (this.articulo.es_nacional === null) {
        this.errors.es_nacional = "Por favor seleccione si es Nacional o Internacional"
      }

      if (this.articulo.autores.length <= 0) {
        this.errors.autores = "Por favor ingrese un autor";
      }

      if (this.errors.es_nacional !== null || this.errors.autores !== null) {
        return;
      }

      await this.artStore.crearArtReferato(this.articulo)
        .catch(e => console.error(e))
        .then(data => {
          if (data.status == 201) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoArtReferato' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoArtReferato' });
    },

    agregarAutor: function () {
      this.articulo.autores.push(this.autorSeleccionado);
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.articulo.autores.includes(autor.id))
    },

    eliminarAutor: function (autor_id) {
      let autorIndex = this.articulo.autores.indexOf(autor_id);
      this.articulo.autores.splice(autorIndex, 1);
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.articulo.autores.includes(autor.id))
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
