import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

axios.defaults.baseURL = '/api';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);
app.mount('#app');
