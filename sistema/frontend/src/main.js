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
import * as bootstrap from 'bootstrap';
const app = createApp(App);
const pinia = createPinia();

app.use(Toast)
app.use(pinia);
app.use(router);

app.mount('#app');



axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8080';
window.bootstrap = bootstrap;
