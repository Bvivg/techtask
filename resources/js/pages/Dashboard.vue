<template>
  <div>
    {{ user ? user.name : null }}
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import IUser from '../interfaces/IUser';
import Request from '../Request';

const user = ref<IUser>()
const fetchUser = async () => {
  try {
    const response = await Request.get<IUser>('/user/');
    user.value = response;
  } catch (error) {
    console.error('Error fetching user:', error);
  }
}
onMounted(() => {
  fetchUser();  
})
</script>

<style scoped></style>