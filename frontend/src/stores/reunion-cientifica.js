import { defineStore } from 'pinia'
import axios from 'axios'

export const useReunionCientificaStore = defineStore('reunion-cientifica', {
  actions: {
    async listarReuniones() {
      return await axios.get(import.meta.env.VITE_API_URL + '/reunion-cientifica', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearReunion(reunion) {
      return axios.post(import.meta.env.VITE_API_URL + '/reunion-cientifica', reunion, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    detalleReunion(reunion_id) {
      return axios.get(import.meta.env.VITE_API_URL + '/reunion-cientifica/' + reunion_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    editarReunion(reunion_id, reunion) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/reunion-cientifica/' + reunion_id,
        reunion,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    eliminarReunion(reunion_id) {
      return axios.delete(import.meta.env.VITE_API_URL + '/reunion-cientifica/' + reunion_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    }
  }
})
