import { createApp } from 'vue';
import './public/js/bootstrap.bundle.min.js';
import './public/css/bootstrap.min.css';
import App from './src/App.vue';
import router from './src/router/index.js';
import axios from 'axios';

const app = createApp(App);
app.use(router);
app.mount('#app');

axios.defaults.baseURL = 'http://localhost:8080';
axios.defaults.withCredentials = true
export default axios;
