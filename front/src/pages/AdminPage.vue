<template>
  <Layout>
    <div class="container mx-auto p-4">
      <div class="flex justify-center items-center">  
        <div class="flex flex-col gap-1">
          <h1 class="text-2xl">Welcome, <span class="font-bold">{{user.name}}</span></h1>
          <p>Your email: <span class="font-bold">{{ user.email }}</span></p>
          <template v-if="!user.email_verified_at">
            <p class="text-red-600">Your email is not verified.</p>
            <button @click="resendConfirmationEmail" class="bg-yellow-600 text-white px-3 max-w-[300px]
            py-2 rounded hover:bg-yellow-700 mt-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 
            focus:ring-opacity-50">Resend Confirmation Email</button>
            <p class="text-green-500">{{ success }}</p>
          </template>
          <div class="flex flex-col sm:flex-row gap-1 max-w-[300px]">
            <button @click="confirmResetPassword" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 w-full">Reset Password</button>
            <button @click="confirmLogout" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 
            focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 w-full">Logout</button>
          </div>
        </div>
      </div>
      <h2 class="text-xl font-bold mb-4 mt-4">Leads:</h2>
      <p v-if="user.email_verified_at && !leads.length">No leads in the database</p>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <div v-for="lead in leads" :key="lead.id" class="border p-4 rounded-lg shadow-md overflow-hidden break-words">
          <p><strong>First name:</strong> {{ lead.first_name }}</p>
          <p><strong>Last name:</strong> {{ lead.last_name }}</p>
          <p><strong>Email:</strong> {{ lead.email }}</p>
          <p><strong>Phone number:</strong> {{ lead.phone }}</p>
          <p><strong>Message:</strong> {{ lead.message }}</p>
          <div class="flex gap-2 mt-2">
            <router-link :to="`/leads/edit/${lead.id}`" class="bg-blue-600 text-white px-3 py-2 
            rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500
            focus:ring-opacity-50">Edit</router-link>
            <button @click="confirmDeleteLead(lead.id)" class="bg-red-600 text-white px-3 py-2 
            rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 
            focus:ring-opacity-50">Delete</button>
          </div>
        </div>
      </div>
      <p class="text-red-500">{{ error }}</p>
    </div>
  </Layout>
</template>

<script setup>
import {ref} from 'vue'
import axios from '@/axios'
import { useRouter } from 'vue-router';

const router = useRouter();

const user = ref(JSON.parse(localStorage.getItem('user')));

const leads = ref([])
const error = ref('')
const success = ref('');


const getLeads = async () => {
  try {
    const response = await axios.get('/leads');
    leads.value=response.data
    
    console.log(response.data);

  } catch (err) {
    console.log(err);

    error.value = err.response?.data?.message || 'Login failed';
  }
};

const getUser = async () => {
  try {
    const response = await axios.get('/user');
    user.value=response.data.user
    localStorage.setItem('user', JSON.stringify(response.data.user));
    console.log(response.data);
  } catch (err) {
    console.log(err);
  }
};


const confirmResetPassword = () => {
  if (window.confirm("Are you sure you want to reset your password?")) {
    resetPassword();
  }
};

const resetPassword = async () => {
  try {
    await axios.post('/forgot-password');
    alert('Password reset link has been sent to your email.')
  } catch (error) {
    console.error('Logout failed:', error);
  }
};

const confirmLogout = () => {
  if (window.confirm("Are you sure you want to log out?")) {
    logout();
  }
};

const logout = async () => {
  try {
    await axios.post('/logout');
    localStorage.removeItem('authToken');
    localStorage.removeItem('user');
    router.push('/').then(() => {
      setTimeout(() => {
        window.location.reload();
      }, 300)
    });
  } catch (error) {
    console.error('Logout failed:', error);
    localStorage.removeItem('authToken');
    localStorage.removeItem('user');
    router.push('/').then(() => {
      setTimeout(() => {
        window.location.reload();
      }, 300)
    });
  }
};

const resendConfirmationEmail = async () => {
  try {
    const response = await axios.post('/email/resend');
    console.log(response);
    success.value = 'Confirmation email has been resent.';
    alert('Confirmation email has been sent!');
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to resend confirmation email.';
  }
};


const confirmDeleteLead = (id) => {
  if (window.confirm("Are you sure you want to delete this lead?")) {
    deleteLead(id);
  }
};

const deleteLead = async (id) => {
  try {
    await axios.delete(`/leads/${id}`);
    leads.value = leads.value.filter(lead => lead.id !== id);
    success.value = 'Lead deleted successfully.';
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to delete lead.';
  }
};

getUser()
getLeads()
</script>
