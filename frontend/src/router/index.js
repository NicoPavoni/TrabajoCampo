// En tu archivo de configuración de Vue Router (index.js u otro)
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import ListadoArtReferato from '../views/Documentos/ArticuloConReferato/Listado.vue'
import AltaArtReferato from '../views/Documentos/ArticuloConReferato/Alta.vue'
import EditarArtReferato from '../views/Documentos/ArticuloConReferato/Editar.vue'
import ListadoRevistaNacional from '../views/Documentos/RevistaNacional/Listado.vue'
import ListadoLibroCapitulo from '../views/Documentos/LibroCapitulo/Listado.vue'
import ListadoEvento from '../views/Evento/Listado.vue'
import ListadoDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Listado.vue'
import ListadoPatente from '../views/Patente/Listado.vue'
import ListadoRegPropIntelectual from '../views/RegPropIntelectual/Listado.vue'
import ListadoRegPropIndustrial from '../views/RegPropIndustrial/Listado.vue'
import ListadoReunionCientifica from '../views/ReunionCientifica/Listado.vue'

const isLoggedIn = () => {
  if (localStorage.getItem('token')) {
    return true
  }

  return false
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView
    },
    {
      path: '/articulo-referato',
      name: 'listadoArtReferato',
      component: ListadoArtReferato
    },
    {
      path: '/articulo-referato/alta',
      name: 'altaArtReferato',
      component: AltaArtReferato
    },
    {
      path: '/articulo-referato/:id/alta',
      name: 'editarArtReferato',
      component: EditarArtReferato
    },
    {
      path: '/revista-nacional',
      name: 'listadoRevistaNacional',
      component: ListadoRevistaNacional
    },
    {
      path: '/libro-capitulo',
      name: 'listadoLibroCapitulo',
      component: ListadoLibroCapitulo
    },
    {
      path: '/evento',
      name: 'lintadoEvento',
      component: ListadoEvento
    },
    {
      path: '/documento-tecnico',
      name: 'listadoDocumentoTecnico',
      component: ListadoDocumentoTecnico
    },
    {
      path: '/patente',
      name: 'listadoPatente',
      component: ListadoPatente
    },
    {
      path: '/registro-propiedad-intelectual',
      name: 'listadoPropiedadIntelectual',
      component: ListadoRegPropIntelectual
    },
    {
      path: '/registro-propiedad-industrial',
      name: 'listadoPropiedadIndustrial',
      component: ListadoRegPropIndustrial
    },
    {
      path: '/reunion-cientifica',
      name: 'listadoReunionCientifica',
      component: ListadoReunionCientifica
    }
  ]
})

router.beforeEach((to, from) => {
  if (to.name !== 'login' && !isLoggedIn()) return { name: 'login' }
})

export default router
