import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import { createPinia } from 'pinia';
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import '../public/css/bootstrap.min.css';
import '../public/js/bootstrap.bundle.min.js';
import  '../public/css/cropper.css';
import  '../public/js/cropper.js';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../public/css/main.css';
import '../public/css/cropper.css';
import '../public/js/cropper.js';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8080';

const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

const app = createApp(App);

app.use(createPinia());
app.use(Toast);
app.use(router);

app.mount('#app');
