import { defineStore } from 'pinia'
import axios from 'axios'

export const usePersonaStore = defineStore('persona', {
  state: () => ({
    persona: null,
    personas: null
  }),

  getters: {
    getPersona: (state) => state.persona,
    getPersonas: (state) => state.personas
  },

  actions: {
    listarPersonas() {
      return axios
        .get(import.meta.env.VITE_API_URL + '/parametricas/personas', {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        })
        .catch((e) => console.error(e))
        .then((data) => {
          this.personas = data.data
          return true
        })
    }
  }
})
