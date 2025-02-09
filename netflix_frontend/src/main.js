import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Import router
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000/api';
const app = createApp(App);
app.config.globalProperties.$axios = axios; // Make Axios globally available
app.use(router);
app.mount('#app');
