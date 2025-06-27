<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center text-primary mb-4">Criar Conta no Trampix</h2>

            <form @submit.prevent="register">
                <!-- Nome -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input v-model="name" type="text" class="form-control" id="name" required />
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input v-model="email" type="email" class="form-control" id="email" required />
                </div>

                <!-- Senha -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input v-model="password" type="password" class="form-control" id="password" required />
                </div>

                <!-- Confirmar Senha -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input v-model="password_confirmation" type="password" class="form-control" id="password_confirmation" required />
                </div>

                <!-- Botão -->
                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')

const register = async () => {
    try {
        axios.get('http://localhost:8080/sanctum/csrf-cookie', { withCredentials: true })
        const response = await axios.post('/api/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value
        })
        localStorage.setItem('token', response.data.token)
        router.push('/')
    } catch (error: any) {
        alert('Erro ao registrar: ' + (error?.response?.data?.message || 'Erro desconhecido'))
    }
}
</script>
