<template>
  <div class="container mt-5">
    <div class="row justify-content-center">

      <form v-if="isLogin" @submit="handleRegister" class="col-md-6">
        <h2>Register</h2>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" v-model="data.name" @input="handleChange"
            required />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" v-model="data.email" @input="handleChange"
            required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" v-model="data.password"
            @input="handleChange" required />
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
        <p class="mt-3 text-center">Already have an account? <a href="#" @click="toggleForm">Login</a></p>
      </form>
      <form v-else @submit="handleLogin" class="col-md-6">
        <h2>Login</h2>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" v-model="data.email" @input="handleChange"
            required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" v-model="data.password"
            @input="handleChange" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="mt-3 text-center">Don't have an account? <a href="#" @click="toggleForm">Register</a></p>
      </form>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Request from "../Request";
import router from "../router";
import IResponse from "../interfaces/IResponse";
const isLogin = ref(true); 
const toggleForm = () => {
  isLogin.value = !isLogin.value; 
};
const data = ref({
  name: "",
  email: "",
  password: ""
});


const handleChange = (e: Event) => {
  const target = e.target as HTMLInputElement;
  data.value[target.name] = target.value;
};

const handleLogin = async (e: Event) => {
  e.preventDefault();
  try {
    const response = await Request.post<IResponse, any>('/login', data.value);
    if (response.error) {
      throw new Error(response.error);
    }
    if (response.token) {
      localStorage.setItem('auth_token', response.token);
      console.log(response.message);
      router.push('/')
    }
  } catch (e) {
    console.error(e);
    throw e;
  }
};

const handleRegister = async (e: Event) => {
  e.preventDefault();
  try {
    const response = await Request.post<IResponse, any>('/register', data.value);
    if (response.error) {
      throw new Error(response.error);
    }
    console.log(response.message);
    toggleForm()
  } catch (e) {
    console.log(e);
    throw e;
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
}
</style>
