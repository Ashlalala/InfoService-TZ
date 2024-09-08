<template>
  <div class="container mx-auto p-4 max-w-md">
      <h1 class="text-2xl font-bold mb-4">Форма обращения</h1>
      <form @submit.prevent="submitForm">
          <div class="mb-4">
              <label for="first_name" class="block text-sm font-medium text-gray-700">Имя</label>
              <input
                  id="first_name"
                  v-model="form.first_name"
                  type="text"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
              />
          </div>
          <div class="mb-4">
              <label for="last_name" class="block text-sm font-medium text-gray-700">Фамилия</label>
              <input
                  id="last_name"
                  v-model="form.last_name"
                  type="text"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
              />
          </div>
          <div class="mb-4">
              <label for="phone" class="block text-sm font-medium text-gray-700">Номер телефона</label>
              <input
                  id="phone"
                  v-model="form.phone"
                  type="tel"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
              />
          </div>
          <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
              />
          </div>
          <div class="mb-4">
              <label for="message" class="block text-sm font-medium text-gray-700">Текст обращения</label>
              <textarea
                  id="message"
                  v-model="form.message"
                  rows="4"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
              ></textarea>
          </div>
          <p class="text-red-500">{{ error }}</p>
          <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
              Отправить
          </button>
      </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
      return {
          form: {
              first_name: '',
              last_name: '',
              phone: '',
              email: '',
              message: ''
          },
          error: null
      };
  },
  methods: {
      async submitForm() {
          try {
              await axios.post('http://localhost:8000/api/leads', this.form);
              alert('Заявка отправлена успешно!');
              this.resetForm();
          } catch (err) {
              console.error('Ошибка при отправке заявки:', err);
              this.error = err.response?.data
              alert('Oшибка при отправке заявки.');
          }
      },
      resetForm() {
          this.form = {
              first_name: '',
              last_name: '',
              phone: '',
              email: '',
              message: ''
          };
          this.error=null;
          
      }
  }
};
</script>
