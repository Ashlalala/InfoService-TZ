<template>
  <Layout>
    <div class="container mx-auto p-4 max-w-md">
      <h1 class="text-2xl mb-4">Edit Lead</h1>
      <div v-if="lead">
        <form @submit.prevent="updateLead">
          <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input v-model="lead.first_name" type="text" id="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
          <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input v-model="lead.last_name" type="text" id="last_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input v-model="lead.email" type="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
          <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input v-model="lead.phone" type="text" id="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
          <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea v-model="lead.message" id="message" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
          </div>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Save</button>
          <p class="text-red-500 mt-2">{{ error }}</p>
        </form>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '@/axios';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

const lead = ref(null);
const error = ref('');

const fetchLead = async () => {
  try {
    const response = await axios.get(`/leads/${route.params.id}`);
    lead.value = response.data;
  } catch (err) {
    console.error(err);
    error.value = 'Failed to fetch lead details.';
  }
};

const updateLead = async () => {
  try {
    await axios.put(`/leads/${lead.value.id}`, lead.value);
    alert('Lead updated successfully');
    router.push('/admin');
  } catch (err) {
    console.error(err);
    error.value = 'Failed to update lead.';
  }
};

onMounted(() => {
  fetchLead();
});
</script>
