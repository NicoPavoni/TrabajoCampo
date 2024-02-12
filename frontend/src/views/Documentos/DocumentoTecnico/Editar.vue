<template>
  <DefaultLayout>
    <form @submit="editarDocumentoTecnico">
      <div class="container d-flex flex-column mt-5" v-if="!loadingAutores">
        <h2 class="text-center mb-4 center-content">Documento Tecnico - Editar</h2>

        <div class="d-flex flex-column  flex-md-row justify-content-center">
          <div class="mb-3 me-3">
            <label for="nombreDocTecnico" class="form-label fw-bold">Nombre del Documento</label>
            <input v-model="documento.nombre" type="text" class="form-control" id="nombreDocTecnico" placeholder="Nombre"
              required>
          </div>

          <div class="mb-3 me-3">
            <label for="lugar" class="form-label fw-bold">Lugar</label>
            <input v-model="documento.lugar" type="text" class="form-control" id="lugar" placeholder="Lugar" required>
          </div>

          <div class="mb-3">
            <label for="fecha" class="form-label fw-bold">Fecha</label>
            <div class="input-group">
              <input v-model="documento.fecha" type="date" class="form-control" id="fecha" placeholder="Fecha" required>
            </div>
          </div>
        </div>

        <div class="mb-3 d-flex flex-column align-items-center justify-content-center">
          <div class="mb-3">
            <label class="form-label mb-2 fw-bold" for="tipoDocTecnico">Tipo de Documento Tecnico</label>

            <select name="tipoDocTecnico" id="tipoDocTecnico" class="form-control"
              v-model="documento.tipo_documento_tecnico_id">
              <option value="" disabled hidden>Seleccione un tipo</option>
              <option v-for=" tipo in tiposDocTecnico" :value="tipo.id" :key="tipo.id">{{ tipo.nombre }}</option>
            </select>
          </div>
          <span v-if="errors.tipo_doc_tecnico" class="small text-danger">{{ errors.tipo_doc_tecnico }}</span>
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
        <div class="overflow-auto mb-4 mt-3" v-if="documento.autores.length > 0">
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

        <div class="d-flex flex-column align-items-center">
          <label class="form-label fw-bold mb-2 mt-4">Enlaces</label>
          <div class="input-group input-autor">
            <input v-model="enlace" type="text" class="form-control" id="enlace" placeholder="Enlace">
            <div class="input-group-append">
              <button @click="agregarEnlace" class="btn btn-success" type="button">
                <i class="bi bi-plus me-1 text-light"></i>Agregar
              </button>
            </div>
          </div>
        </div>

        <!-- sección contenedora para centrar el input y la tabla -->
        <div class="overflow-auto mb-4 mt-3" v-if="documento.enlaces.length > 0">
          <!-- Tabla de Enlaces -->
          <table class="table mx-auto text-center">
            <thead>
              <tr>
                <th scope="col">Enlace</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(enlace, i) in  documento.enlaces " :key="i">
                <td class="text-start"><a href="{{ enlace }}">{{ enlace }}</a></td>
                <td class="">
                  <i @click="() => eliminarEnlace(i)" class="bi bi-trash"></i>
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
          <i class="bi bi-plus me-1" :class="{ 'd-none': loading }"></i>Editar Documento
        </button>
      </div>
    </form>

    <div class="alert alert-success align-self-center" v-if="mensajeExito">Documento Tecnico actualizado exitosamente.
      Redireccionando al listado...
    </div>
    <div class="alert alert-danger align-self-center" v-if="mensajeError">{{ mensajeError }}</div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '../../../layouts/DefaultLayout.vue';
import { useDocTecnicoStore } from '@/stores/documento-tecnico';
import { useDocumentoStore } from '@/stores/documento';
import { usePersonaStore } from '@/stores/persona';
import { useParametricaStore } from '@/stores/parametricas';
import { useRouter } from 'vue-router';
</script>

<script>


export default {

  async mounted() {
    const docStore = useDocTecnicoStore();
    const documentoStore = useDocumentoStore();
    const personaStore = usePersonaStore();
    const parametricaStore = useParametricaStore();
    await personaStore.listarPersonas();
    await parametricaStore.listarTiposDocumentoTecnicos().then((response) => {
      this.tiposDocTecnico = response.data;
    });
    this.mensajeError = null;
    await documentoStore.detalleDocumento(this.$route.params.id)
      .catch(e => console.error(e))
      .then(data => {
        if (data.status == 401) {
          localStorage.clear();
          this.$router.push({ name: "login" })
        } else if (data.status == 200) {
          if (!data.data.hasOwnProperty('documento_tecnico')) {
            this.mensajeError = "Error en el editar: Este documento no es un Documento Tecnico"
          }
          this.documento.nombre = data.data.nombre;
          this.documento.lugar = data.data.documento_tecnico.lugar;
          this.documento.fecha = data.data.documento_tecnico.fecha;
          this.documento.tipo_documento_tecnico_id = data.data.documento_tecnico.tipo_documento_tecnico_id;
          let enlaces = data.data.documento_tecnico.enlaces.map((enlace) => enlace.enlace);
          this.documento.enlaces = enlaces;
          let autores = data.data.autores.map(autor => autor.id)
          this.documento.autores = autores;
          this.loadingAutores = false;
          this.loading = false;
        }
      })

    this.autores = personaStore.getPersonas;
    this.autoresNoSeleccionados = this.autores.filter((autor) => !this.documento.autores.includes(autor.id))

    this.docStore = docStore;

  },

  data() {
    return {
      "errors": {
        "tipo_doc_tecnico": null,
        "autores": null
      },
      "documento": {
        "nombre": null,
        "lugar": null,
        "fecha": null,
        "tipo_documento_tecnico_id": null,
        "autores": [],
        "enlaces": [],
      },
      "autores": [],
      "autoresNoSeleccionados": [],
      "autorSeleccionado": null,
      "enlace": null,
      "mensajeExito": null,
      "mensajeError": null,
      loadingAutores: true,
      "loading": true
    }
  },
  computed: {
    autoresSeleccionados() {
      return this.autores.filter((autor) => this.documento.autores.includes(autor.id))
    }
  },

  methods: {
    editarDocumentoTecnico: async function (e) {
      e.preventDefault();
      console.log("Entre al form")
      this.errors = {
        "tipo_doc_tecnico": null,
        "autores": null
      }

      if (this.documento.tipo_documento_tecnico_id === null) {
        this.errors.tipo_doc_tecnico = "Por favor seleccione un tipo de documento tecnico"
      }

      if (this.documento.autores.length <= 0) {
        this.errors.autores = "Por favor ingrese un autor";
      }

      if (this.errors.tipo_doc_tecnico !== null || this.errors.autores !== null) {
        return;
      }

      this.loading = true;
      await this.docStore.editarDocTecnico(this.$route.params.id, this.documento)
        .catch(e => console.error(e))
        .then(data => {
          this.loading = false;
          if (data.status == 200) {
            this.mensajeExito = true;
            setTimeout(() => this.$router.push({ name: 'listadoDocumentoTecnico' }), 5000)
          } else if (data.status == 401) {
            localStorage.clear();
            this.$router.push({ name: 'login' })
          }
        });
    },

    cancelar: function () {
      this.$router.push({ name: 'listadoDocumentoTecnico' });
    },

    agregarAutor: function () {
      if (!this.autorSeleccionado) {
        return;
      }
      this.documento.autores.push(this.autorSeleccionado);
      this.autorSeleccionado = null;
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.documento.autores.includes(autor.id))
    },

    eliminarAutor: function (autor_id) {
      let autorIndex = this.documento.autores.indexOf(autor_id);
      this.documento.autores.splice(autorIndex, 1);
      this.autoresNoSeleccionados = this.autores.filter((autor) => !this.documento.autores.includes(autor.id))
    },

    agregarEnlace: function () {
      if (!this.enlace) {
        return;
      }
      this.documento.enlaces.push(this.enlace);
      this.enlace = null;
    },

    eliminarEnlace: function (indice) {
      this.documento.enlaces.splice(indice, 1);
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
