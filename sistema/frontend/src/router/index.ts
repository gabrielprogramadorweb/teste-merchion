import { createRouter, createWebHistory } from 'vue-router'

import TaskView from '@/views/Task/TaskView.vue'
import LoginView from '@/views/Auth/Login/LoginView.vue'
import RegisterView from '@/views/Auth/Register/RegisterView.vue'
import DashboardView from '@/views/Dashboard/DashboardView.vue'
import ProfileEdit from '@/views/Profile/ProfileEdit.vue';

const routes = [
    { path: '/', name: 'Dashboard', component: DashboardView },
    { path: '/tasks', name: 'Tasks', component: TaskView },
    { path: '/login', name: 'Login', component: LoginView },
    { path: '/register', name: 'Register', component: RegisterView },
    {path: '/perfil/editar',  name: 'EditarPerfil',component: ProfileEdit, meta: { requiresAuth: true }}
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
