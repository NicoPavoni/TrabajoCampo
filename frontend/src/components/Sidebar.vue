<script setup>
const props = defineProps(['open']);
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();

const isActive = (ruta) => {
  return route.fullPath == ruta;
}

const logout = () => {
  localStorage.clear();
  router.push({ name: 'login' });
}
</script>

<template>
  <div class="flex-shrink-0 p-3 bg-white border-end offcanvas offcanvas-start overflow-y-auto"
    :class="{ show: props.open }" style="max-width: 280px;" id="offcanvasSidebar">
    <div class="d-flex border-bottom pb-3 mb-3 align-items-center justify-content-between">
      <a href="/home" class="d-flex align-items-center link-dark text-decoration-none text-black">
        <span class="fs-5 fw-semibold">Modulo GCC </span>
      </a>
      <button class="btn" @click="$emit('cerrarSidebar')"><i class="bi bi-chevron-left me-2"></i></button>
    </div>

    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <router-link to="/home" class="btn align-items-center rounded" :class="{ active: isActive('/home') }">
          Home
        </router-link>
      </li>
      <li class="mb-1">
        <router-link to="/reunion-cientifica" class="btn align-items-center rounded"
          :class="{ active: isActive('/reunion-cientifica') }">
          Reuniones Cientificas
        </router-link>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
          data-bs-target="#trabajos-cientificos-collapse" aria-expanded="false">
          Trabajos Cientificos
        </button>
        <div class="collapse" id="trabajos-cientificos-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li class="sidebar-link rounded">
              <router-link to="/revista-nacional">En Revistas Nacionales</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/articulo-referato" class="sidebar-link">Articulos con Referato</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/libros-capitulos">Libros Capitulos</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/eventos" class="sidebar-link">Eventos</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/articulos-informes" class="sidebar-link">Articulos, informes y memorias</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/patentes-desarrollos" class="sidebar-link">Pat. desarrollos y cert.</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/registro-propiedad-intelectual" class="sidebar-link">Reg. de Prop.
                Intelectual</router-link>
            </li>
            <li class="sidebar-link rounded">
              <router-link to="/registro-propiedad-industrial" class="sidebar-link">Reg. de Prop.Industrial</router-link>
            </li>
          </ul>
        </div>
      </li>
      <li class="border-top my-3"></li>
      <li class="mb-1">
        <button class="btn align-items-center rounded fw-semibold text-danger" @click="logout()">
          <i class="bi bi-box-arrow-in-right me-2"></i>Cerrar Sesión
        </button>
      </li>
    </ul>
  </div>
</template>

<style scoped>
li.sidebar-link>a {
  margin-left: 0.5em;
  text-decoration: none;
  color: var(--bs-dark);
}

li.sidebar-link>a:hover {
  color: var(--bs-dark-text-emphasis);
}


.btn-toggle {
  display: inline-flex;
}

/* Muestra la flechita al lado de los collapsable del sidebar */
button.btn-toggle::before {
  content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
  width: 1.25em;
  line-height: 0;
  transition: transform .35s ease;
  transform-origin: .5em 50%;
}

/* Rota la flechita 90 grados cuando se expande el collapse del sidebar */
button.btn-toggle[aria-expanded="true"]::before {
  transform: rotate(90deg);
}

.btn.active {
  width: 100%;
  border: 0;
  background-color: #6c4c99;
  color: white;
  font-weight: 500;
}

.sidebar-link {
  width: 100%;
  padding-top: 0.25em;
  padding-bottom: 0.25em;
  margin-top: 0.25em;
  margin-bottom: 0.25em;
}

.sidebar-link.active {
  background-color: #6c4c99;
  font-weight: 500;
}

.sidebar-link.active>a {
  color: white;
}

.sidebar-link.active:hover>a {
  color: white;
}

.btn:focus,
.btn:active,
.btn {
  border: 0;
  outline: 0;
  box-shadow: none;
  transition: 0s;

}
</style>
