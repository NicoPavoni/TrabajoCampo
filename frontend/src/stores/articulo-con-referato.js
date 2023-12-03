import { defineStore } from 'pinia'

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
    crearArtReferato(articulo) {
      return axios
        .post('/api/documento/articulo-con-referato', articulo)
        .catch((e) => console.error(e))
        .then((response) => response.json())
        .then((data) => (this.articulo = data.articulo_con_referato))
    }
  }
})
