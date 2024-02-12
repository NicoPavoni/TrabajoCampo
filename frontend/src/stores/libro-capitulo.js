import { defineStore } from 'pinia'
import axios from 'axios'

export const useLibroCapituloStore = defineStore('libro-capitulo', {
  actions: {
    async listarLibroCapitulos() {
      return await axios.get(import.meta.env.VITE_API_URL + '/documento/1', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearLibroCapitulo(libroCapitulo) {
      return axios.post(import.meta.env.VITE_API_URL + '/documento/libro-capitulo', libroCapitulo, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    editarLibroCapitulo(documento_id, libroCapitulo) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/documento/libro-capitulo/' + documento_id,
        libroCapitulo,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    }
  }
})
