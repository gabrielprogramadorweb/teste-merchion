import {createRouter, createWebHistory} from 'vue-router'

import TaskView from '@/pages/Task/TaskView.vue'
import LoginView from '@/pages/Auth/Login/LoginView.vue'
import RegisterView from '@/pages/Auth/Register/RegisterView.vue'
import HomeView from '@/pages/Home/HomeView.vue'
import ProfileEditView from '@/pages/Profile/ProfileEditView.vue';

const routes = [
    {path: '/', name: 'Home', component: HomeView, meta: {requiresAuth: true}},
    {path: '/tasks', name: 'Tasks', component: TaskView},
    {path: '/login', name: 'Login', component: LoginView},
    {path: '/register', name: 'Register', component: RegisterView},
    {path: '/perfil/editar', name: 'EditarPerfil', component: ProfileEditView, meta: {requiresAuth: true}}
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token')

    if (to.meta.requiresAuth && !token) {
        next('/login')
    } else if ((to.path === '/login' || to.path === '/register') && token) {
        next('/')
    } else {
        next()
    }
})

export default router
