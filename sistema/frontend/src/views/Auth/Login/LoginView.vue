<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center text-primary mb-4">Entrar no FlowTask</h2>

            <form @submit.prevent="login">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input v-model="email" type="email" class="form-control" id="email" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Senha</label>
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" class="form-control pe-4" id="password" required />
                    <span class="position-absolute" style="top: 38px; right: 12px; cursor: pointer; z-index: 10;" @click="showPassword = !showPassword">
                      <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" style="font-size: 1.1rem; color: #6c757d;"></i>
                     </span>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <router-link to="/register" class="btn btn-outline-primary">Criar Conta</router-link>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useLogin } from './useLogin'
const { email, password, showPassword, login } = useLogin()
</script>
