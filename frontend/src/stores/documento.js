import { defineStore } from 'pinia'
import axios from 'axios'

export const useDocumentoStore = defineStore('documento', {
  actions: {
    detalleDocumento(documento_id) {
      return axios.get(import.meta.env.VITE_API_URL + '/documento/ver/' + documento_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    eliminarDocumento(documento_id) {
      return axios.delete(import.meta.env.VITE_API_URL + '/documento/' + documento_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    }
  }
})
