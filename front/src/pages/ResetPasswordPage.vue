<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded">
    <h1 class="text-2xl font-bold mb-6 text-center">Reset Password</h1>

    <template v-if="!success">        
      <!-- New Password Input -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
      <input
        type="password"
        v-model="password"
        id="password"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        placeholder="Enter your new password"
        />
      </div>

      <!-- Confirm Password Input -->
      <div class="mb-4">
        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input
        type="password"
          v-model="confirmPassword"
          id="confirmPassword"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
          placeholder="Confirm your new password"
          />
        </div>
        
        <!-- Submit Button -->
        <div>
          <button
          @click="submitResetPassword"
          class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
          >
          Reset Password
        </button>
      </div>
    </template>

    <p v-if="error" class="text-red-500 mt-4">{{ error }}</p>
    <p v-if="success" class="text-green-500 mt-4">{{ success }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import axios from '@/axios';


const route = useRoute();

// Get email and token from URL query parameters
const email = route.query.email;
const resetToken = route.query.token;

const password = ref('');
const confirmPassword = ref('');
const error = ref('');
const success = ref('');

// Function to handle the password reset form submission
const submitResetPassword = async () => {
  error.value = '';  // Reset error message
  success.value = '';  // Reset success message

  // Simple form validation
  if (!password.value || !confirmPassword.value) {
    error.value = 'Please fill in all fields.';
    return;
  }
  if (password.value !== confirmPassword.value) {
    error.value = 'Passwords do not match.';
    return;
  }

  console.log(resetToken);
  
  // Send password reset request to the API
  try {
    const response = await axios.post('/reset-password', {
      email: email,
      password: password.value,
      password_confirmation: confirmPassword.value,
      token: resetToken,
    });
    console.log(response);
    success.value = 'Password reset successful.';
  } catch (err) {
    console.log(err);
    
    error.value = err.response?.data;
  }
};
</script>

