<style scoped>
main {
  min-height: 100vh;
}

.logo-utn {
  width: 300px;
  margin-left: auto;
  margin-right: auto;
}
</style>

<template>
  <main class="d-flex flex-column align-self-center justify-content-center col-11 col-md-6 col-lg-4">
    <div class="card py-3">
      <img src="../../assets/img/logo-utn.png" alt="UTN logo" class="logo-utn">
      <hr class="mx-2">
      <form class="col-11 align-self-center d-flex flex-column" @submit="login">
        <div class="mb-3">
          <label for="email" class="form-label">Correo electronico</label>
          <input type="email" class="form-control" id="email" placeholder="mail@example.com" v-model="email">
          <span class="small text-danger ms-3" v-if="errors.email">{{ errors.email }}</span>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="secret1234"
            v-model="password">
          <span class="small text-danger ms-3" v-if="errors.password">{{ errors.password }}</span>
        </div>
        <button type="submit" class="btn btn-success align-self-center" :disabled="loading">
          <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" v-if="loading"></span>
          Ingresar
        </button>

      </form>
    </div>
  </main>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      errors: {
        email: undefined,
        password: undefined,
      },
      email: "",
      password: "",
      loading: false
    }
  },

  methods: {
    async login(e) {
      e.preventDefault();

      this.errors = {
        email: undefined,
        password: undefined,
      };

      if (!this.validarEmail(this.email)) {
        this.errors.email = "Email invalido";
        return;
      }

      if (!this.password) {
        this.errors.password = "Ingrese una contraseña";
      }

      this.loading = true;
      let response = await axios.get(import.meta.env.VITE_API_URL)

      response = await axios.post("http://172.24.0.4:80/login/", {
        email: this.email,
        password: this.password
      }, {
        headers: {
          'Accept': 'application/json'
        }
      }).then((data) => response.json())
        .catch(e => {
          console.error(e)
          this.loading = false
        });
      this.loading = false

      console.log(response);
    },

    validarEmail(email) {
      if (email) {
        let regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        return regex.test(this.email)
      }
    }
  }
}
</script>