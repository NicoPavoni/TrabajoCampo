// En tu archivo de configuración de Vue Router (index.js u otro)
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'

import ListadoArtReferato from '../views/Documentos/ArticuloConReferato/Listado.vue'
import AltaArtReferato from '../views/Documentos/ArticuloConReferato/Alta.vue'
import EditarArtReferato from '../views/Documentos/ArticuloConReferato/Editar.vue'
import DetalleArtReferato from '../views/Documentos/ArticuloConReferato/Detalle.vue'

import ListadoRevistaNacional from '../views/Documentos/RevistaNacional/Listado.vue'
// import AltaRevistaNacional from '../views/Documentos/RevistaNacional/Alta.vue'
// import EditarRevistaNacional from '../views/Documentos/RevistaNacional/Editar.vue'
// import DetalleRevistaNacional from '../views/Documentos/RevistaNacional/Detalle.vue'

import ListadoLibroCapitulo from '../views/Documentos/LibroCapitulo/Listado.vue'
import AltaLibroCapitulo from '../views/Documentos/LibroCapitulo/Alta.vue'
import EditarLibroCapitulo from '../views/Documentos/LibroCapitulo/Editar.vue'
import DetalleLibroCapitulo from '../views/Documentos/LibroCapitulo/Detalle.vue'

import ListadoDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Listado.vue'
import AltaDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Alta.vue'
import EditarDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Editar.vue'
import DetalleDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Detalle.vue'

import ListadoEvento from '../views/Evento/Listado.vue'
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
    // Articulo con referato
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
      path: '/articulo-referato/:id/editar',
      name: 'editarArtReferato',
      component: EditarArtReferato
    },
    {
      path: '/articulo-referato/:id',
      name: 'detalleArtReferato',
      component: DetalleArtReferato
    },
    // \Articulo con referato

    // Revista nacional
    {
      path: '/revista-nacional',
      name: 'listadoRevistaNacional',
      component: ListadoRevistaNacional
    },
    // {
    //   path: '/revista-nacional/alta',
    //   name: 'altaRevistaNacional',
    //   component: AltaRevistaNacional
    // },
    // {
    //   path: '/revista-nacional/:id/editar',
    //   name: 'editarRevistaNacional',
    //   component: EditarRevistaNacional
    // },
    // {
    //   path: '/revista-nacional/:id',
    //   name: 'detalleRevistaNacional',
    //   component: DetalleRevistaNacional
    // },
    // \Revista nacional

    // Libro/Capitulo
    {
      path: '/libro-capitulo',
      name: 'listadoLibroCapitulo',
      component: ListadoLibroCapitulo
    },
    {
      path: '/libro-capitulo/alta',
      name: 'altaLibroCapitulo',
      component: AltaLibroCapitulo
    },
    {
      path: '/libro-capitulo/:id/editar',
      name: 'editarLibroCapitulo',
      component: EditarLibroCapitulo
    },
    {
      path: '/libro-capitulo/:id',
      name: 'detalleLibroCapitulo',
      component: DetalleLibroCapitulo
    },

    {
      path: '/documento-tecnico',
      name: 'listadoDocumentoTecnico',
      component: ListadoDocumentoTecnico
    },
    {
      path: '/documento-tecnico/alta',
      name: 'altaDocumentoTecnico',
      component: AltaDocumentoTecnico
    },
    {
      path: '/documento-tecnico/:id/editar',
      name: 'editarDocumentoTecnico',
      component: EditarDocumentoTecnico
    },
    {
      path: '/documento-tecnico/:id',
      name: 'detalleDocumentoTecnico',
      component: DetalleDocumentoTecnico
    },

    {
      path: '/evento',
      name: 'lintadoEvento',
      component: ListadoEvento
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
