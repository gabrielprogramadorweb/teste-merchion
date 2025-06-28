<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center text-primary mb-4">Entrar no FlowTask</h2>

            <form @submit.prevent="login">
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input v-model="email" type="email" class="form-control" id="email" required />
                </div>

                <!-- Senha -->
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Senha</label>
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" class="form-control pe-4" id="password" required />
                    <span class="position-absolute" style="top: 38px; right: 12px; cursor: pointer; z-index: 10;" @click="showPassword = !showPassword">
            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" style="font-size: 1.1rem; color: #6c757d;"></i>
          </span>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-4">
                    <router-link to="/register" class="btn btn-outline-primary">Criar Conta</router-link>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</template>


<script lang="ts" setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

axios.defaults.withCredentials = true

const router = useRouter()
const email = ref('')
const password = ref('')
const showPassword = ref(false)

const login = async () => {
    try {
        await axios.get('http://localhost:8080/sanctum/csrf-cookie', {
            withCredentials: true
        });

        const response = await axios.post('http://localhost:8080/api/login', {
            email: email.value,
            password: password.value
        }, {
            withCredentials: true
        });

        const token = response.data.token;

        const userData = {
            id: response.data.user.id,
            name: response.data.user.name
        };

        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(userData));

        router.push('/').then(() => {
            window.location.reload();
        });

    } catch (error: any) {
        alert('Erro ao fazer login: ' + (error?.response?.data?.message || 'Erro desconhecido'));
    }
};

</script>
