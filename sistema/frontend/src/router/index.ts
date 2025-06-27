import { createRouter, createWebHistory } from 'vue-router'

import TaskView from '../views/TaskView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import DashboardView from '../views/DashboardView.vue'

const routes = [
    {
        path: '/',
        name: 'Dashboard',
        component: DashboardView
    },
    {
        path: '/tasks',
        name: 'Tasks',
        component: TaskView
    },
    {
        path: '/login',
        name: 'Login',
        component: LoginView
    },
    {
        path: '/register',
        name: 'Register',
        component: RegisterView
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
