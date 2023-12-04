import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    token: null
  }),

  getters: {
    getUser: (state) => state.user,
    getToken: (state) => state.token
  },

  actions: {
    logIn(email, password) {
      return fetch(import.meta.env.VITE_API_URL + '/login', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          email: email,
          password: password
        })
      })
    }
  }
})
