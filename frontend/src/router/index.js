import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'

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
      component: () => import('../views/HomeView.vue')
    }
  ]
})

router.beforeEach((to, from) => {
  if (to.name !== 'login' && !isLoggedIn()) return { name: 'login' }
})

export default router
