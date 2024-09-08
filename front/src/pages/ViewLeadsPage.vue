<template>
  <Layout>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold">List of leads:</h1>
      <div>
        {{ leads }}
      </div>
      <p class="text-red-500">{{ error }}</p>
    </div>
  </Layout>
</template>

<script setup>
import {ref} from 'vue'
import axios from '@/axios'

const leads = ref([])
const error = ref('')

const getLeads = async () => {
  try {
    const response = await axios.get('/leads');
    console.log(response.data);
  } catch (err) {
    console.log(err);

    error.value = err.response?.data?.message || 'Login failed';
  }
};

getLeads()
</script>
