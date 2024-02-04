import { defineStore } from 'pinia'
import axios from 'axios'

export const useRevistaStore = defineStore('revista-nacional', {
  actions: {
    async listarDocTecnicos() {
      return await axios.get(import.meta.env.VITE_API_URL + '/documento/2', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearDocTecnico(revistaNacional) {
      return axios.post(
        import.meta.env.VITE_API_URL + '/documento/revista-nacional',
        revistaNacional,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    editarDocTecnico(documento_id, revistaNacional) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/documento/revista-nacional/' + documento_id,
        revistaNacional,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    }
  }
})
