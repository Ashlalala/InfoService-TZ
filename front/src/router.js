import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/pages/HomePage.vue';
import Login from '@/pages/LoginPage.vue';
import Register from '@/pages/RegisterPage.vue';
import Admin from '@/pages/AdminPage.vue';
import ResetPassword from '@/pages/ResetPasswordPage.vue';
import EditLead from '@/pages/EditLeadPage.vue';


const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/admin', component: Admin, meta: { requiresAuth: true } },
  { path: '/reset-password', component: ResetPassword },
  { path: '/leads/edit/:id', name: 'EditLead', component: EditLead, props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
