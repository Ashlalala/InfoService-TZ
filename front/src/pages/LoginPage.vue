<template>
  <Layout>
    <div class="container mx-auto p-4 max-w-md">
      <h1 class="text-2xl font-bold mb-4">Login</h1>
      <form @submit.prevent="login">
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input v-model="email" id="email" type="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input v-model="password" id="password" type="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
        <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
      </form>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import axios from '@/axios';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const error = ref('');
const router = useRouter();

const login = async () => {
  try {
    const response = await axios.post('/login', {
      email: email.value,
      password: password.value,
    });
    localStorage.setItem('authToken', response.data.token);
    localStorage.setItem('user', JSON.stringify(response.data.user));
    console.log(response.data);
    
    router.push('/admin').then(() => {
      setTimeout(() => {
        window.location.reload();
      }, 300)
    });

  } catch (err) {
    console.log(err);
    error.value = err.response?.data?.message || 'Login failed';
  }
};
</script>


