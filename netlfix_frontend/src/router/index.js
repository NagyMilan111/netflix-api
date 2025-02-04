import { createRouter, createWebHistory } from 'vue-router';
import DashboardPage from '@/components/DashboardPage.vue';
import UsersPage from '@/components/UsersPage.vue';
import DataPage from '@/components/DataPage.vue';

const routes = [
  { path: '/', redirect: '/dashboard' }, // Default route
  { path: '/dashboard', component: DashboardPage },
  { path: '/users', component: UsersPage },
  { path: '/data', component: DataPage}
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
