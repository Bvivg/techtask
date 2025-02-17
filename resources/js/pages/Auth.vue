<template>
  <div>

  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Request from "../Request"
const data = ref({ name: "", email: "", password: "" })
interface ILoginResponse {
  token: string;
  user: IUser;
}

interface IUser {
  id: number;
  name: string;
  email: string;
  email_verified_at: string | null;
  password: string;
  remember_token: string;
  created_at: string;
  updated_at: string;
}

const handleChange = (e: Event) => {
  const target = e.target as HTMLInputElement
  data.value[target.name] = target.value;
}
const handleLogin = async (e: Event) => {
  e.preventDefault();
  try {
    const response = await Request.post<ILoginResponse, any>('/auth', data);
    localStorage.setItem('auth_token', response.token)
    console.log('Logged in successfully');
  } catch (e) {
    console.error(e);
    throw e
  }
}
const handleRegister = async (e: Event) => {
  e.preventDefault();
  try {
    
  } catch (e) {
    console.log(e);
    throw e
  }
}
</script>

<style scoped></style>