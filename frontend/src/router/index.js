// En tu archivo de configuración de Vue Router (index.js u otro)
import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '../views/LoginView.vue';
import HomeView from '../views/HomeView.vue';
import ArticuloReferato from '../views/ArticuloConReferato.vue';
import RevistasNacionales from '../views/RevistasNacionales.vue';
import LibrosCapitulos from '../views/LibrosCapitulos.vue';
import Eventos from '../views/Eventos.vue';
import ArticulosInformes from '../views/ArticulosInformes.vue';
import PatentesDesarrollos from '../views/PatentesDesarrollos.vue';
import RegistroPropiedadIntelectual from '../views/RegistroPropiedadIntelectual.vue';
import RegistroPropiedadIndustrial from '../views/RegistroPropiedadIndustrial.vue';


const isLoggedIn = () => {
  if (localStorage.getItem('token')) {
    return true;
  }

  return false;
};

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/revistas-nacionales',
      name: 'revistasNacionales',
      component: RevistasNacionales,
    },
    {
      path: '/articulo-referato',
      name: 'articuloReferato',
      component: ArticuloReferato,
    },
    {
      path: '/libros-capitulos',
      name: 'librosCapitulos',
      component: LibrosCapitulos,
    },
    {
      path: '/eventos',
      name: 'eventos',
      component: Eventos,
    },
    {
      path: '/articulos-informes',
      name: 'articulosInformes',
      component: ArticulosInformes,
    },
    {
      path: '/patentes-desarrollos',
      name: 'patentesDesarrollos',
      component: PatentesDesarrollos,
    },
    {
      path: '/registro-propiedad-intelecual',
      name: 'propiedadIntelecual',
      component: RegistroPropiedadIntelectual,
    },
    {
      path: '/registro-propiedad-industrial',
      name: 'propiedadIndustrial',
      component: RegistroPropiedadIndustrial,
    },
  ],
});

router.beforeEach((to, from) => {
  if (to.name !== 'login' && !isLoggedIn()) return { name: 'login' };
});

export default router;
