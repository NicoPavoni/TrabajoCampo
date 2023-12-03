<template>
  <DefaultLayout>
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-primary" @click="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h2 class="text-center mb-4 center-content">Articulos con Referato - Alta</h2>
      </div>

      <div class="d-flex justify-content-center">
        <div class="mb-3 me-3">
          <label for="nombreArticulo" class="form-label font-weight-bold">Nombre del Articulo</label>
          <input v-model="nombreArticulo" type="text" class="form-control" id="nombreArticulo" placeholder="Nombre" style="width: 200px;">
        </div>

        <div class="mb-3 me-3">
          <label for="lugar" class="form-label font-weight-bold">Lugar</label>
          <input v-model="lugar" type="text" class="form-control" id="lugar" placeholder="Lugar" style="width: 200px;">
        </div>

        <div class="mb-3">
          <label for="fecha" class="form-label font-weight-bold">Fecha</label>
          <div class="input-group">
            <input v-model="fecha" type="date" class="form-control" id="fecha" placeholder="Fecha">
          </div>
        </div>
      </div>

      <div class="mb-3 d-flex flex-column align-items-center">
        <label class="form-label font-weight-bold mb-2">Tipo de Congreso</label>
        <div class="d-flex">
          <div class="form-check me-3">
            <input v-model="esNacional" class="form-check-input" type="radio" id="nacional" value="true">
            <label class="form-check-label" for="nacional">Nacional</label>
          </div>
          <div class="form-check">
            <input v-model="esNacional" class="form-check-input" type="radio" id="internacional" value="false">
            <label class="form-check-label" for="internacional">Internacional</label>
          </div>
        </div>
      </div>

      <div class="mb-3 d-flex flex-column align-items-center">
        <label class="form-label font-weight-bold mb-2">Autores</label>
        <div class="input-group mb-3" style="width: 250px;">
          <input v-model="autorBuscar" type="text" class="form-control" placeholder="Buscar Autores" aria-label="Buscar Autores">
          <div class="input-group-append">
            <button @click="agregarAutor" class="btn btn-success" type="button">
              <i class="bi bi-plus"></i> Agregar
            </button>
          </div>
        </div>

        <!-- sección contenedora para centrar el input y la tabla -->
        <div class="d-flex flex-column align-items-center">
          <!-- Tabla de Autores -->
          <table class="table" style="width: 476px; margin-top: 10px; border: 1px solid #dee2e6;">
            <thead>
              <tr>
                <th scope="col">Nombre del autor</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(autor, index) in autores" :key="index">
                <td>{{ autor }}</td>
                <td>
                  <i @click="verAutor(index)" class="bi bi-eye"></i>
                  <i @click="eliminarAutor(index)" class="bi bi-trash"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Botones -->
      <div class="d-flex justify-content-center">
        <button @click="cancelar" class="btn btn-danger me-2">
          <i class="bi bi-x me-1"></i>Cancelar
        </button>
        <button @click="crearArticulo" class="btn btn-success">
          <i class="bi bi-plus me-1"></i>Crear Articulo
        </button>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { ref } from 'vue';
import DefaultLayout from '../layouts/DefaultLayout.vue';
const nombreArticulo = ref('');
const lugar = ref('');
const fecha = ref('');
const esNacional = ref(true); // Por defecto, es nacional
const autorBuscar = ref('');
const autores = ref([]);

const cancelar = () => {
  // Lógica para cancelar
};

const crearArticulo = () => {
  const nuevoArticulo = {
    nombre: nombreArticulo.value,
    lugar: lugar.value,
    fecha: fecha.value,
    es_nacional: esNacional.value,
    autores: autores.value,
  };

  axios.post('/api/crear-articulo-con-referato', nuevoArticulo)
    .then(response => {
      // Manejar la respuesta exitosa, redirigir o mostrar un mensaje
      console.log(response.data.message);
    })
    .catch(error => {
      // Manejar el error, mostrar un mensaje, etc.
      console.error(error.response.data.message);
    });
};

const agregarAutor = () => {
  if (autorBuscar.value) {
    autores.value.push(autorBuscar.value);
    autorBuscar.value = ''; // Limpiar el input después de agregar el autor
  }
};

const verAutor = (index) => {
  // Lógica para ver detalles del autor
  console.log('Ver autor:', autores.value[index]);
};

const eliminarAutor = (index) => {
  autores.value.splice(index, 1);
};
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
</style>
