import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '@/components/LoginPage.vue';
import RegistrationPage from '@/components/RegistrationPage.vue';
import DashboardPage from '@/components/DashboardPage.vue';
import UsersPage from '@/components/UsersPage.vue';
import DataPage from '@/components/DataPage.vue';

const routes = [
  { path: '/', component: LoginPage }, // Default route
  { path: '/login', component: LoginPage },
  { path: '/register', component: RegistrationPage },
  { path: '/dashboard', component: DashboardPage },
  { path: '/users', component: UsersPage },
  { path: '/data', component: DataPage }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
