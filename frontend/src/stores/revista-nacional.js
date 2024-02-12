import { defineStore } from 'pinia'
import axios from 'axios'

export const useRevistaNacionalStore = defineStore('revista-nacional', {
  actions: {
    async listarRevistaNacionales() {
      return await axios.get(import.meta.env.VITE_API_URL + '/documento/2', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearRevistaNacional(revistaNacional) {
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

    editarRevistaNacional(documento_id, revistaNacional) {
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
