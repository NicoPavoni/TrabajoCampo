// En tu archivo de configuración de Vue Router (index.js u otro)
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import ArticuloReferato from '../views/Documentos/ArticuloConReferato/Alta.vue'
import RevistaNacional from '../views/Documentos/RevistaNacional/Alta.vue'
import LibroCapitulo from '../views/Documentos/LibroCapitulo/Alta.vue'
import Eventos from '../views/Evento/Alta.vue'
import ArticulosInformes from '../views/Documentos/DocumentoTecnico/Alta.vue'
import PatenteDesarrollo from '../views/Patente/Alta.vue'
import RegistroPropiedadIntelectual from '../views/RegPropIntelectual/Alta.vue'
import RegistroPropiedadIndustrial from '../views/RegPropIndustrial/Alta.vue'

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
      path: '/revistas-nacionales',
      name: 'revistasNacionales',
      component: RevistaNacional
    },
    {
      path: '/articulo-referato',
      name: 'articuloReferato',
      component: ArticuloReferato
    },
    {
      path: '/libros-capitulos',
      name: 'librosCapitulos',
      component: LibroCapitulo
    },
    {
      path: '/eventos',
      name: 'eventos',
      component: Eventos
    },
    {
      path: '/articulos-informes',
      name: 'articulosInformes',
      component: ArticulosInformes
    },
    {
      path: '/patentes-desarrollos',
      name: 'patentesDesarrollos',
      component: PatenteDesarrollo
    },
    {
      path: '/registro-propiedad-intelecual',
      name: 'propiedadIntelecual',
      component: RegistroPropiedadIntelectual
    },
    {
      path: '/registro-propiedad-industrial',
      name: 'propiedadIndustrial',
      component: RegistroPropiedadIndustrial
    }
  ]
})

router.beforeEach((to, from) => {
  if (to.name !== 'login' && !isLoggedIn()) return { name: 'login' }
})

export default router
