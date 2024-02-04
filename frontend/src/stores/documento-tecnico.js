import { defineStore } from 'pinia'
import axios from 'axios'

export const useDocTecnicoStore = defineStore('documento-tecnico', {
  actions: {
    async listarDocTecnicos() {
      return await axios.get(import.meta.env.VITE_API_URL + '/documento/4', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearDocTecnico(documento) {
      return axios.post(import.meta.env.VITE_API_URL + '/documento/documento-tecnico', documento, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    editarDocTecnico(documento_id, documento) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/documento/documento-tecnico/' + documento_id,
        documento,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    }
  }
})
