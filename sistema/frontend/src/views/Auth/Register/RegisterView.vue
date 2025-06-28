<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center text-primary mb-4">Criar Conta no FlowTask</h2>

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

                <!-- Campo: Senha -->
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Senha</label>
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" class="form-control pe-4" id="password" required />
                    <span class="position-absolute"style="top: 38px; right: 12px; cursor: pointer; z-index: 10;" @click="togglePassword">
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" style="font-size: 1.1rem; color: #6c757d;"></i>
                      </span>
                </div>

                <!-- Campo: Confirmar Senha -->
                <div class="mb-4 position-relative">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input :type="showPasswordConfirm ? 'text' : 'password'" v-model="password_confirmation" class="form-control pe-4" id="password_confirmation" required/>
                    <span class="position-absolute" style="top: 38px; right: 12px; cursor: pointer; z-index: 10;" @click="togglePasswordConfirm">
                        <i :class="showPasswordConfirm ? 'bi bi-eye-slash' : 'bi bi-eye'" style="font-size: 1.1rem; color: #6c757d;"></i>
                      </span>
                </div>
                <!-- Botão -->
                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useRegister } from './useRegister'

const {
    name, email, password, password_confirmation,
    showPassword, showPasswordConfirm,
    togglePassword, togglePasswordConfirm,
    register
} = useRegister()
</script>
