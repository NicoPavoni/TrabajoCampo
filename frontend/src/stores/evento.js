import { defineStore } from 'pinia'
import axios from 'axios'

export const useEventoStore = defineStore('evento', {
  actions: {
    async listarEventos() {
      return await axios.get(import.meta.env.VITE_API_URL + '/evento', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearEvento(evento) {
      return axios.post(import.meta.env.VITE_API_URL + '/evento', evento, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    detalleEvento(evento_id) {
      return axios.get(import.meta.env.VITE_API_URL + '/evento/' + evento_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    editarEvento(evento_id, evento) {
      return axios.put(import.meta.env.VITE_API_URL + '/evento/' + evento_id, evento, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    eliminarEvento(evento_id) {
      return axios.delete(import.meta.env.VITE_API_URL + '/evento/' + evento_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    }
  }
})
