<script setup>

</script>

<template>
  <div class="flex-shrink-0 p-3 bg-white border-end offcanvas offcanvas-start show" id="offcanvasSidebar">
    <a href="/home" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none text-black border-bottom">
      <span class="fs-5 fw-semibold">Modulo GCC</span>
    </a>
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <router-link to="/home" class="btn align-items-center rounded">
          Home
        </router-link>
      </li>
      <li class="mb-1">
        <router-link to="" class="btn align-items-center rounded">
          Reuniones Cientificas
        </router-link>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
          data-bs-target="#trabajos-cientificos-collapse" aria-expanded="false">
          Trabajos Cientificos
        </button>
        <div class="collapse" id="trabajos-cientificos-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li>
              <router-link to="/home" class="sidebar-link">En Revistas Nacionales</router-link>
            </li>
            <li><router-link to="/" class="sidebar-link">Articulos con Referato</router-link></li>
            <li><router-link to="/" class="sidebar-link">Libros/Capitulos</router-link></li>
            <li><router-link to="/" class="sidebar-link">Eventos</router-link></li>
            <li><router-link to="/" class="sidebar-link">Articulos, informes y memorias</router-link></li>
            <li><router-link to="/" class="sidebar-link">Pat. desarrollos y cert.</router-link></li>
            <li><router-link to="/" class="sidebar-link">Reg. de Prop. Intelectual</router-link></li>
            <li><router-link to="/" class="sidebar-link">Reg. de Prop. Industrial</router-link></li>
          </ul>
        </div>
      </li>
      <li class="border-top my-3"></li>
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
          data-bs-target="#account-collapse" aria-expanded="false">
          Account
        </button>
        <div class="collapse" id="account-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="sidebar-link">New...</a></li>
            <li><a href="#" class="sidebar-link">Profile</a></li>
            <li><a href="#" class="sidebar-link">Settings</a></li>
            <li><a href="#" class="sidebar-link">Sign out</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>

<style scoped>
li>a.sidebar-link {
  margin-left: 2.5em;
  text-decoration: none;
  color: var(--bs-dark);
}

li>a.sidebar-link:hover {
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
  background-color: #B44AAB80;
}
</style>
