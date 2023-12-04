<template>
    <DefaultLayout>
      <h2 class="text-center">Listado de Articulo con Referato</h2>
      <router-link to="/articulo-referato/alta" class="text-center">Ir al alta</router-link>
  
      <table class="table mx-auto text-center">
        <thead>
          <tr>
            <th scope="col">Nombre </th>
            <th scope="col">Localidad</th>
            <th scope="col">Fecha</th>
            <th scope="col">Tipo de congreso</th>
            <th scope="col">Autores</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="articulo in articulos" :key="articulo.id">
            <td>{{ articulo.nombre }}</td>
            <td>{{ articulo.lugar }}</td>
            <td>{{ articulo.fecha }}</td>
            <td>{{ articulo.es_nacional ? 'Nacional' : 'Internacional' }}</td>
            <td>
              <!-- Itera sobre los autores de este artículo -->
              <span v-for="autor in articulo.autores" :key="autor.id">
                {{ autor.nombre }} {{ autor.apellido }}
              </span>
            </td>
            <td>
              <button @click="verDetalles(articulo.id)">Detalles</button>
            </td>
          </tr>
        </tbody>
      </table>
    </DefaultLayout>
  </template>
  
  <script setup>
  import DefaultLayout from '../../../layouts/DefaultLayout.vue';
  
  import { ref, onMounted } from 'vue';
  
  const articulos = ref([]);
  
  onMounted(() => {

  });
  </script>
  
  <style scoped></style>
  