import { defineStore } from 'pinia'
import axios from 'axios'

export const useArtReferatoStore = defineStore('articulo-con-referato', {
  state: () => ({
    articulo: null,
    articulos: null
  }),

  getters: {
    getArticulo: (state) => state.articulo,
    getArticulos: (state) => state.articulos
  },

  actions: {
    async listarArticulos() {
      return await axios.get(import.meta.env.VITE_API_URL + '/documento/3', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearArtReferato(articulo) {
      return axios.post(
        import.meta.env.VITE_API_URL + '/documento/articulo-con-referato',
        articulo,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    detalleArtReferato(documento_id) {
      return axios.get(import.meta.env.VITE_API_URL + '/documento/ver/' + documento_id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    editarArtReferato(documento_id, articulo) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/documento/articulo-con-referato/' + documento_id,
        articulo,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    }
  }
})
