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
      <form class="col-11 align-self-center d-flex flex-column" @submit="login" @keyup.enter="submit">
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
import { useUserStore } from '../stores/user';
import { useRouter } from 'vue-router';
export default {
  setup() {
    if (localStorage.getItem('token')) {
      const router = useRouter()
      router.push({ name: 'home' })
    }
    const userStore = useUserStore()
    return { userStore }
  },

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
      if (this.loading) return;
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
        return;
      }

      this.loading = true;

      let response = await this.userStore.logIn(this.email, this.password)
        .then(() => {
          setTimeout(() => { this.loading = false }, 1000)
          this.$router.push({ name: 'home' })
        });
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