<template>
    <div class="container d-flex justify-content-center align-items-center vh-100" style="background-color:#111827;">
        <div class="p-4 w-100"
             style="max-width:420px;border-radius:12px;background-color:#111827;border:2px solid #0dc9ee; position:relative;">
            <div
                style="position:absolute;top:-2px;left:-2px;right:-2px;bottom:-2px;z-index:-1;border-radius:12px;background:linear-gradient(90deg,#0dc9ee,#0d6dfb);"></div>
            <h2 class="text-center mb-4" style="color:#ffffff;">Entrar no FlowTask</h2>

            <form @submit.prevent="login">
                <div class="mb-3 position-relative">
                    <label for="email" class="form-label text-white">E-mail</label>
                    <input v-model="email" type="email" id="email" required class="form-control pe-5"
                           :style="{ backgroundColor: 'transparent', color: '#fff', border: email && !validaEmail ? '2px solid #28a745' : email && validaEmail ? '2px solid #dc3545' : '1px solid #0dc9ee' }"/>
                    <span v-if="email" class="position-absolute" style="top: 38px; right: 12px;">
                        <i v-if="!validaEmail" class="bi bi-check-circle-fill" style="color:#28a745;"></i>
                        <i v-else class="bi bi-exclamation-circle-fill" style="color:#dc3545;"></i>
                    </span>
                    <div v-if="email && validaEmail" class="text-danger mt-1" style="font-size: 0.85rem;">
                        {{ validaEmail }}
                    </div>
                </div>

                <div class="mb-4 position-relative">
                    <label for="password" class="form-label text-white">Senha</label>
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" id="password" required
                           class="form-control pe-5"
                           :style="{ backgroundColor: 'transparent', color: '#fff', border: password && validaPassword.length === 0 ? '2px solid #28a745' : password && validaPassword.length > 0 ? '2px solid #dc3545' : '1px solid #0dc9ee' }"/>
                    <span v-if="password"
                          class="position-absolute"
                          style="top: 38px; right: 40px; cursor: pointer;"
                          @click="showPassword = !showPassword">
                             <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"
                           style="font-size: 1.1rem; color: #ccc;"></i>
                    </span>
                    <span v-if="password" class="position-absolute" style="top: 38px; right: 12px;">
                        <i v-if="validaPassword.length === 0" class="bi bi-check-circle-fill"
                           style="color:#28a745;"></i>
                        <i v-else class="bi bi-exclamation-circle-fill" style="color:#dc3545;"></i>
                    </span>
                    <ul class="mt-2 text-danger" style="font-size: 0.8rem; padding-left: 18px;"
                        v-if="password && validaPassword.length">
                        <li v-for="(erro, index) in validaPassword" :key="index">{{ erro }}</li>
                    </ul>
                </div>

                <div class="d-flex justify-content-between">
                    <router-link to="/register" class="btn btn-outline-light"
                                 style="border-color:#0dc9ee;color:#0dc9ee;transition: all 0.3s ease;"
                                 onmouseover="this.style.background='linear-gradient(90deg,#0dc9ee,#0d6dfb)'; this.style.color='#111827'; this.style.fontWeight='bold'; this.style.border='none';"
                                 onmouseout="this.style.background='transparent'; this.style.color='#0dc9ee'; this.style.fontWeight='normal'; this.style.border='1px solid #0dc9ee';">
                        Criar Conta
                    </router-link>
                    <button type="submit" class="btn"
                            style="background:linear-gradient(90deg,#0dc9ee,#0d6dfb);border:none;color:#111827;font-weight:bold;">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {useLogin} from './useLogin'

const {
    email,
    password,
    showPassword,
    login,
    validaEmail,
    validaPassword
} = useLogin()
</script>
