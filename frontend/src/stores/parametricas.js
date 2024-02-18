import { defineStore } from 'pinia'
import axios from 'axios'

export const useParametricaStore = defineStore('parametricas', {
  actions: {
    async listarTiposLicencia() {
      return await axios.get(import.meta.env.VITE_API_URL + '/parametricas/tipos-licencias', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },
    async listarInstituciones() {
      return await axios.get(import.meta.env.VITE_API_URL + '/parametricas/instituciones', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    },
    async listarTiposDocumentoTecnicos() {
      return await axios.get(
        import.meta.env.VITE_API_URL + '/parametricas/tipos-documento-tecnico',
        {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }
      )
    },
    async listarTrabajosPublicados() {
      return await axios.get(import.meta.env.VITE_API_URL + '/parametricas/trabajos-publicados', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      })
    }
  }
})
