import { createRouter, createWebHistory } from 'vue-router'

import TaskView from '@/pages/Task/TaskView.vue'
import LoginView from '@/pages/Auth/Login/LoginView.vue'
import RegisterView from '@/pages/Auth/Register/RegisterView.vue'
import DashboardView from '@/pages/Dashboard/DashboardView.vue'
import ProfileEditView from '@/pages/Profile/ProfileEditView.vue';

const routes = [
    { path: '/', name: 'Dashboard', component: DashboardView },
    { path: '/tasks', name: 'Tasks', component: TaskView },
    { path: '/login', name: 'Login', component: LoginView },
    { path: '/register', name: 'Register', component: RegisterView },
    {path: '/perfil/editar',  name: 'EditarPerfil',component: ProfileEditView, meta: { requiresAuth: true }}
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
