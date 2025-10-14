import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Students from '../pages/Students.vue';
import Teams from '../pages/Teams.vue';
import Analytics from '../pages/Analytics.vue';

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/students', name: 'students', component: Students },
  { path: '/teams', name: 'teams', component: Teams },
  { path: '/analytics', name: 'analytics', component: Analytics },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
