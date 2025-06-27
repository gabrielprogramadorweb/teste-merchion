import { createApp } from 'vue';
import '../public/js/bootstrap.bundle.min.js';
import '../public/css/bootstrap.min.css';
import App from './App.vue';
import router from './router';
import axios from 'axios';

const app = createApp(App);
app.use(router);
app.mount('#app');

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8080';
