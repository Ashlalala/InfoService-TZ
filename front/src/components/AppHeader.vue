<template>
  <header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">InfoService</h1>
      <nav>
        <RouterLink
          to="/"
          class="mr-4 hover:underline cursor-pointer"
          :class="{ 'font-bold': isActive('/') }"
        >
          Home
        </RouterLink>
        <template v-if="user">
          <RouterLink
            to="/admin"
            class="mr-4 hover:underline cursor-pointer"
            :class="{ 'font-bold': isActive('/admin') }"
          >
            Admin
          </RouterLink>
        </template>
        <template v-else>
          <RouterLink
            to="/login"
            class="mr-4 hover:underline cursor-pointer"
            :class="{ 'font-bold': isActive('/login') }"
          >
            Login
          </RouterLink>
          <RouterLink
            to="/register"
            class="mr-4 hover:underline cursor-pointer"
            :class="{ 'font-bold': isActive('/register') }"
          >
            Register
          </RouterLink>
        </template>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();

const user = localStorage.getItem('user');

// Determine if the link is active
const isActive = (path) => {
  return route.path === path;
};
</script>


