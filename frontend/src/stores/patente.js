import { defineStore } from 'pinia'
import axios from 'axios'

export const usePatenteStore = defineStore('patente', {
  actions: {
    async listarPatentes() {
      return await axios.get(import.meta.env.VITE_API_URL + '/patente', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearPatente(patente) {
      return axios.post(import.meta.env.VITE_API_URL + '/patente', patente, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    detallePatente(patente_id) {
      return axios.get(import.meta.env.VITE_API_URL + '/patente/' + patente_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    editarPatente(patente_id, patente) {
      return axios.put(import.meta.env.VITE_API_URL + '/patente/' + patente_id, patente, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    eliminarPatente(patente_id) {
      return axios.delete(import.meta.env.VITE_API_URL + '/patente/' + patente_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    }
  }
})
