<template>
  <DefaultLayout>
    <form @submit="editarLibroCapitulo">
      <div class="container d-flex flex-column mt-5" v-if="!loadingAutores">
        <h2 class="text-center mb-4 center-content">Libros y Capítulos - Editar</h2>

        <div class="d-flex flex-column  flex-md-row justify-content-center">
          <div class="mb-3 me-3">
            <label for="nombre" class="form-label fw-bold">Nombre del Libro/Capítulo(s)</label>
            <input v-model="libroCapitulo.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre"
              required>
          </div>

          <div class="mb-3 me-3">
            <label for="isbn" class="form-label fw-bold">ISBN</label>
            <input v-model="libroCapitulo.isbn" type="text" class="form-control" id="isbn" placeholder="ISBN" required>
          </div>

          <div class="mb-3">
            <label for="editorial" class="form-label fw-bold">Editorial</label>
            <input v-model="libroCapitulo.editorial" type="text" class="form-control" id="editorial"
              placeholder="Editorial" required>
          </div>
        </div>

        <div class="mb-3 d-flex flex-column  align-items-center">
          <div class="mb-3 me-3">
            <label for="nro_capitulo" class="form-label fw-bold">N° Capítulo</label>
            <input v-model="libroCapitulo.nro_capitulo" type="text" class="form-control" id="nro_capitulo"
              placeholder="Opcional">
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
        <div class="overflow-auto mb-4 mt-3" v-if="libroCapitulo.autores.length > 0">
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
          <i class="bi bi-plus me-1" :class="{ 'd-none': loading }"></i>Editar Libro/Capítulo
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Libro/Capítulo actualizado exitosamente.
      Redireccionando al listado...
    </div>
    <div class="alert alert-danger align-self-center" v-if="mensajeError">{{ mensajeError }}</div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { useLibroCapituloStore } from '@/stores/libro-capitulo';
import { usePersonaStore } from '@/stores/persona';
import { useDocumentoStore } from '@/stores/documento';
import { useRouter } from 'vue-router';
</script>

<script>


export default {

  async mounted() {
    const storeLC = useLibroCapituloStore();
    const documentoStore = useDocumentoStore();
    const personaStore = usePersonaStore();

    await personaStore.listarPersonas();
    this.mensajeError = null;
    await documentoStore.detalleDocumento(this.$route.params.id)
      .catch(e => console.error(e))
      .then(data => {
        if (data.status == 401) {
          localStorage.clear();
          this.$router.push({ name: "login" })
        } else if (data.status == 200) {
          if (!data.data.hasOwnProperty('libro_capitulo')) {
            this.mensajeError = "Error en el editar: Este documento no es un Libro/Capítulo"
          }
          this.libroCapitulo.nombre = data.data.nombre;
          this.libroCapitulo.isbn = data.data.libro_capitulo.isbn;
          this.libroCapitulo.editorial = data.data.libro_capitulo.editorial;
          this.libroCapitulo.nro_capitulo = data.data.libro_capitulo.nro_capitulo;
          let autores = data.data.autores.map(autor => autor.id)
          this.libroCapitulo.autores = autores;
          this.loadingAutores = false;
          this.loading = false;
        }
      })

    this.autores = personaStore.getPersonas;
    this.autoresNoSeleccionados = this.autores.filter((autor) => !this.libroCapitulo.autores.includes(autor.id))

    this.storeLC = storeLC;

  },

  data() {
    return {
      "errors": {
        "autores": null
      },
      "libroCapitulo": {
        "nombre": null,
        "isbn": null,
        "editorial": null,
        "nro_capitulo": null,
        "autores": []
      },
      "autores": [],
      "autoresNoSeleccionados": [],
      "autorSeleccionado": null,
      "mensajeExito": null,
      "mensajeError": null,
      loadingAutores: true,
      "loading": true
    }
  },
  computed: {
    autoresSeleccionados() {
      return this.autores.filter((autor) => this.libroCapitulo.autores.includes(autor.id))
    }
  },

  methods: {
    editarLibroCapitulo: async function (e) {
      e.preventDefault();

      this.errors = {
        "autores": null
      }

      if (this.libroCapitulo.autores.length <= 0) {
        this.errors.autores = "Por favor ingrese un autor";
      }

      if (this.errors.autores !== null) {
        return;
      }

      this.loading = true;
      await this.storeLC.editarLibroCapitulo(this.$route.params.id, this.libroCapitulo)
        .catch(e => console.error(e))
        .then(data => {
          this.loading = false;
          if (data.status == 200) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoLibroCapitulo' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoLibroCapitulo' });
    },

    agregarAutor: function () {
      if (!this.autorSeleccionado) {
        return;
      }
      this.libroCapitulo.autores.push(this.autorSeleccionado);
      this.autorSeleccionado = null;
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.libroCapitulo.autores.includes(autor.id))
    },

    eliminarAutor: function (autor_id) {
      let autorIndex = this.libroCapitulo.autores.indexOf(autor_id);
      this.libroCapitulo.autores.splice(autorIndex, 1);
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.libroCapitulo.autores.includes(autor.id))
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

input[type='number'] {
  -moz-appearance: textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
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
