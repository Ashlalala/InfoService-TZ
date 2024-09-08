<template>
  <div>
    <AppHeader />
    <main class="p-4">
      <slot></slot>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '@/components/AppHeader.vue';
import AppFooter from '@/components/AppFooter.vue';
</script>

