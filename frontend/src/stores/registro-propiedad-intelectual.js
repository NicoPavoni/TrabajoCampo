import { defineStore } from 'pinia'
import axios from 'axios'

export const useRegPropIntelectualStore = defineStore('regPropIntelectual', {
  actions: {
    async listarRegPropIntelectuales() {
      return await axios.get(import.meta.env.VITE_API_URL + '/registro-propiedad/intelectual', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearRegPropIntelectual(regPropIntelectual) {
      return axios.post(
        import.meta.env.VITE_API_URL + '/registro-propiedad/intelectual',
        regPropIntelectual,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    detalleRegPropIntelectual(regPropIntelectual_id) {
      return axios.get(
        import.meta.env.VITE_API_URL + '/registro-propiedad/intelectual/' + regPropIntelectual_id,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    editarRegPropIntelectual(regPropIntelectual_id, regPropIntelectual) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/registro-propiedad/intelectual/' + regPropIntelectual_id,
        regPropIntelectual,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    eliminarRegPropIntelectual(regPropIntelectual_id) {
      return axios.delete(
        import.meta.env.VITE_API_URL + '/registro-propiedad/intelectual/' + regPropIntelectual_id,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    }
  }
})
