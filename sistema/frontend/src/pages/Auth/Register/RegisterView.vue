<template>
    <div class="container d-flex justify-content-center align-items-center vh-100" style="background-color:#111827; margin-top:40px;">
        <div class="p-4 w-100" style="max-width:420px;border-radius:12px;background-color:#111827;border:2px solid #0dc9ee;background-clip:padding-box;position:relative;">
            <div style="position:absolute;top:-2px;left:-2px;right:-2px;bottom:-2px;z-index:-1;border-radius:12px;background:linear-gradient(90deg,#0dc9ee,#0d6dfb);"></div>
            <h2 class="text-center mb-4" style="color:#ffffff;">Criar Conta no FlowTask</h2>
            <form @submit.prevent="register">
                <div class="mb-3">
                    <label for="name" class="form-label text-white">Nome</label>
                    <input v-model="name" type="text" class="form-control" id="name" required style="background-color:transparent;border:1px solid #0dc9ee;color:#fff;" />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-white">E-mail</label>
                    <input v-model="email" type="email" class="form-control" id="email" required style="background-color:transparent;border:1px solid #0dc9ee;color:#fff;" />
                </div>
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label text-white">Senha</label>
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" class="form-control pe-4" id="password" required style="background-color:transparent;border:1px solid #0dc9ee;color:#fff;" />
                    <span class="position-absolute" style="top:38px;right:12px;cursor:pointer;" @click="togglePassword">
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" style="font-size:1.1rem;color:#ccc;"></i>
                    </span>
                </div>
                <div class="mb-4 position-relative">
                    <label for="password_confirmation" class="form-label text-white">Confirmar Senha</label>
                    <input :type="showPasswordConfirm ? 'text' : 'password'" v-model="password_confirmation" class="form-control pe-4" id="password_confirmation" required style="background-color:transparent;border:1px solid #0dc9ee;color:#fff;" />
                    <span class="position-absolute" style="top:38px;right:12px;cursor:pointer;" @click="togglePasswordConfirm">
                        <i :class="showPasswordConfirm ? 'bi bi-eye-slash' : 'bi bi-eye'" style="font-size:1.1rem;color:#ccc;"></i>
                    </span>
                </div>
                <button type="submit" class="btn w-100" style="background:linear-gradient(90deg,#0dc9ee,#0d6dfb);border:none;color:#111827;font-weight:bold;">Registrar</button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useRegister } from './useRegister'

const {
    name,
    email,
    password,
    password_confirmation,
    showPassword,
    showPasswordConfirm,
    togglePassword,
    togglePasswordConfirm,
    register
} = useRegister()
</script>
