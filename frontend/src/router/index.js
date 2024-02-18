// En tu archivo de configuración de Vue Router (index.js u otro)
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'

import ListadoArtReferato from '../views/Documentos/ArticuloConReferato/Listado.vue'
import AltaArtReferato from '../views/Documentos/ArticuloConReferato/Alta.vue'
import EditarArtReferato from '../views/Documentos/ArticuloConReferato/Editar.vue'
import DetalleArtReferato from '../views/Documentos/ArticuloConReferato/Detalle.vue'

import ListadoRevistaNacional from '../views/Documentos/RevistaNacional/Listado.vue'
import AltaRevistaNacional from '../views/Documentos/RevistaNacional/Alta.vue'
import EditarRevistaNacional from '../views/Documentos/RevistaNacional/Editar.vue'
import DetalleRevistaNacional from '../views/Documentos/RevistaNacional/Detalle.vue'

import ListadoLibroCapitulo from '../views/Documentos/LibroCapitulo/Listado.vue'
import AltaLibroCapitulo from '../views/Documentos/LibroCapitulo/Alta.vue'
import EditarLibroCapitulo from '../views/Documentos/LibroCapitulo/Editar.vue'
import DetalleLibroCapitulo from '../views/Documentos/LibroCapitulo/Detalle.vue'

import ListadoDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Listado.vue'
import AltaDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Alta.vue'
import EditarDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Editar.vue'
import DetalleDocumentoTecnico from '../views/Documentos/DocumentoTecnico/Detalle.vue'

import ListadoEvento from '../views/Evento/Listado.vue'
import AltaEvento from '../views/Evento/Alta.vue'
import EditarEvento from '../views/Evento/Editar.vue'
import DetalleEvento from '../views/Evento/Detalle.vue'

import ListadoPatente from '../views/Patente/Listado.vue'
import AltaPatente from '../views/Patente/Alta.vue'
import EditarPatente from '../views/Patente/Editar.vue'
import DetallePatente from '../views/Patente/Detalle.vue'

import ListadoRegPropIntelectual from '../views/RegPropIntelectual/Listado.vue'
import AltaRegPropIntelectual from '../views/RegPropIntelectual/Alta.vue'
import EditarRegPropIntelectual from '../views/RegPropIntelectual/Editar.vue'
import DetalleRegPropIntelectual from '../views/RegPropIntelectual/Detalle.vue'

import ListadoRegPropIndustrial from '../views/RegPropIndustrial/Listado.vue'
import AltaRegPropIndustrial from '../views/RegPropIndustrial/Alta.vue'
import EditarRegPropIndustrial from '../views/RegPropIndustrial/Editar.vue'
import DetalleRegPropIndustrial from '../views/RegPropIndustrial/Detalle.vue'

import ListadoReunionCientifica from '../views/ReunionCientifica/Listado.vue'
import AltaReunionCientifica from '../views/ReunionCientifica/Alta.vue'
import EditarReunionCientifica from '../views/ReunionCientifica/Editar.vue'
import DetalleReunionCientifica from '../views/ReunionCientifica/Detalle.vue'

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
    {
      path: '/revista-nacional/alta',
      name: 'altaRevistaNacional',
      component: AltaRevistaNacional
    },
    {
      path: '/revista-nacional/:id/editar',
      name: 'editarRevistaNacional',
      component: EditarRevistaNacional
    },
    {
      path: '/revista-nacional/:id',
      name: 'detalleRevistaNacional',
      component: DetalleRevistaNacional
    },
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
    // \Libro/Capitulo

    // Documento Tecnico
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
    // \Documento Tecnico

    // Evento
    {
      path: '/evento',
      name: 'listadoEvento',
      component: ListadoEvento
    },
    {
      path: '/evento/alta',
      name: 'altaEvento',
      component: AltaEvento
    },
    {
      path: '/evento/:id/editar',
      name: 'editarEvento',
      component: EditarEvento
    },
    {
      path: '/evento/:id',
      name: 'detalleEvento',
      component: DetalleEvento
    },
    // \Evento

    // Patente
    {
      path: '/patente',
      name: 'listadoPatente',
      component: ListadoPatente
    },
    {
      path: '/patente/alta',
      name: 'altaPatente',
      component: AltaPatente
    },
    {
      path: '/patente/:id/editar',
      name: 'editarPatente',
      component: EditarPatente
    },
    {
      path: '/patente/:id',
      name: 'detallePatente',
      component: DetallePatente
    },
    // \Patente

    // Registro de Propiedad Intelectual
    {
      path: '/registro-propiedad-intelectual',
      name: 'listadoRegPropIntelectual',
      component: ListadoRegPropIntelectual
    },
    {
      path: '/registro-propiedad-intelectual/alta',
      name: 'altaRegPropIntelectual',
      component: AltaRegPropIntelectual
    },
    {
      path: '/registro-propiedad-intelectual/:id/editar',
      name: 'editarRegPropIntelectual',
      component: EditarRegPropIntelectual
    },
    {
      path: '/registro-propiedad-intelectual/:id',
      name: 'detalleRegPropIntelectual',
      component: DetalleRegPropIntelectual
    },
    // \Registro de Propiedad Intelectual

    // Registro de Propiedad Industrial
    {
      path: '/registro-propiedad-industrial',
      name: 'listadoRegPropIndustrial',
      component: ListadoRegPropIndustrial
    },
    {
      path: '/registro-propiedad-industrial/alta',
      name: 'altaRegPropIndustrial',
      component: AltaRegPropIndustrial
    },
    {
      path: '/registro-propiedad-industrial/:id/editar',
      name: 'editarRegPropIndustrial',
      component: EditarRegPropIndustrial
    },
    {
      path: '/registro-propiedad-industrial/:id',
      name: 'detalleRegPropIndustrial',
      component: DetalleRegPropIndustrial
    },
    // \Registro de Propiedad Industrial

    {
      path: '/reunion-cientifica',
      name: 'listadoReunionCientifica',
      component: ListadoReunionCientifica
    },
    {
      path: '/reunion-cientifica/alta',
      name: 'altaReunionCientifica',
      component: AltaReunionCientifica
    },
    {
      path: '/reunion-cientifica/:id/editar',
      name: 'editarReunionCientifica',
      component: EditarReunionCientifica
    },
    {
      path: '/reunion-cientifica/:id',
      name: 'detalleReunionCientifica',
      component: DetalleReunionCientifica
    }
  ]
})

router.beforeEach((to, from) => {
  if (to.name !== 'login' && !isLoggedIn()) return { name: 'login' }
})

export default router
