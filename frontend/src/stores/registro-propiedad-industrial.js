import { defineStore } from 'pinia'
import axios from 'axios'

export const useRegPropIndustrialStore = defineStore('regPropIndustrial', {
  actions: {
    async listarRegPropIndustriales() {
      return await axios.get(import.meta.env.VITE_API_URL + '/registro-propiedad/industrial', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },

    crearRegPropIndustrial(regPropIndustrial) {
      return axios.post(
        import.meta.env.VITE_API_URL + '/registro-propiedad/industrial',
        regPropIndustrial,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    detalleRegPropIndustrial(regPropIndustrial_id) {
      return axios.get(
        import.meta.env.VITE_API_URL + '/registro-propiedad/industrial/' + regPropIndustrial_id,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    editarRegPropIndustrial(regPropIndustrial_id, regPropIndustrial) {
      return axios.put(
        import.meta.env.VITE_API_URL + '/registro-propiedad/industrial/' + regPropIndustrial_id,
        regPropIndustrial,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },

    eliminarRegPropIndustrial(regPropIndustrial_id) {
      return axios.delete(
        import.meta.env.VITE_API_URL + '/registro-propiedad/industrial/' + regPropIndustrial_id,
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    }
  }
})
