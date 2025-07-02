<template>
    <div class="container d-flex justify-content-center align-items-center vh-100"
         style="background-color:#111827;margin-top:30px;">
        <div class="p-4 w-100"
             style="max-width:420px;border-radius:12px;background-color:#111827;border:2px solid #0dc9ee;position:relative;">
            <div
                style="position:absolute;top:-2px;left:-2px;right:-2px;bottom:-2px;z-index:-1;border-radius:12px;background:linear-gradient(90deg,#0dc9ee,#0d6dfb);"></div>
            <h2 class="text-center mb-4" style="color:#ffffff;">Criar Conta no FlowTask</h2>

            <form @submit.prevent="register">
                <div class="mb-3 position-relative">
                    <label for="name" class="form-label text-white">Nome</label>
                    <input v-model="name" @blur="nameTocado = true" type="text" id="name" required
                           class="form-control pe-5"
                           :style="{ backgroundColor: 'transparent', color: '#fff', border: nameTocado && nameValido ? '2px solid #28a745' : nameTocado && !nameValido ? '2px solid #dc3545' : '1px solid #0dc9ee' }"/>
                    <span v-if="nameTocado" class="position-absolute" style="top: 38px; right: 12px;">
                    <i v-if="nameValido" class="bi bi-check-circle-fill" style="color:#28a745;"></i>
                    <i v-else class="bi bi-exclamation-circle-fill" style="color:#dc3545;"></i>
                  </span>
                </div>

                <div class="mb-3 position-relative">
                    <label for="email" class="form-label text-white">E-mail</label>
                    <input v-model="email" @blur="emailTocado = true" type="email" id="email" required
                           class="form-control pe-5"
                           :style="{ backgroundColor: 'transparent', color: '#fff', border: emailTocado && emailValido ? '2px solid #28a745' : emailTocado && !emailValido ? '2px solid #dc3545' : '1px solid #0dc9ee' }"/>
                    <span v-if="emailTocado" class="position-absolute" style="top: 38px; right: 12px;">
                        <i v-if="emailValido" class="bi bi-check-circle-fill" style="color:#28a745;"></i>
                        <i v-else class="bi bi-exclamation-circle-fill" style="color:#dc3545;"></i>
                    </span>
                    <div v-if="emailTocado && validaEmail" class="text-danger small mt-1">
                        {{ validaEmail }}
                    </div>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label text-white">Senha</label>
                    <input :type="showPassword ? 'text' : 'password'" id="password" v-model="password"
                           @blur="senhaTocada = true" class="form-control pe-5"
                           :style="{ backgroundColor: 'transparent', color: '#fff', border: senhaTocada && senhaValida ? '2px solid #28a745' : senhaTocada && !senhaValida ? '2px solid #dc3545' : '1px solid #0dc9ee' }"/>
                    <span class="position-absolute" style="top: 38px; right: 40px; cursor: pointer;"
                          @click="togglePassword">
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" style="color: #ccc;"></i>
                    </span>
                    <span v-if="senhaTocada" class="position-absolute" style="top: 38px; right: 12px;">
                        <i v-if="senhaValida" class="bi bi-check-circle-fill" style="color: #28a745;"></i>
                        <i v-else class="bi bi-exclamation-circle-fill" style="color: #dc3545;"></i>
                    </span>
                    <div v-if="senhaValida" class="text-success small mt-1">Senha válida.</div>
                    <ul class="mt-2 text-danger small" v-else-if="senhaTocada && validaPassword.length">
                        <li v-for="(erro, i) in validaPassword" :key="i">{{ erro }}</li>
                    </ul>
                </div>

                <div class="mb-4 position-relative">
                    <label for="password_confirmation" class="form-label text-white">Confirmar Senha</label>
                    <input :type="showPasswordConfirm ? 'text' : 'password'" id="password_confirmation"
                           v-model="password_confirmation" @blur="confirmacaoTocada = true" class="form-control pe-5"
                           :style="{ backgroundColor: 'transparent', color: '#fff', border: confirmacaoTocada && confirmacaoValida ? '2px solid #28a745' : confirmacaoTocada && !confirmacaoValida ? '2px solid #dc3545' : '1px solid #0dc9ee' }"/>
                    <span class="position-absolute" style="top: 38px; right: 40px; cursor: pointer;"
                          @click="togglePasswordConfirm">
                        <i :class="showPasswordConfirm ? 'bi bi-eye-slash' : 'bi bi-eye'" style="color: #ccc;"></i>
                    </span>
                    <span v-if="confirmacaoTocada" class="position-absolute" style="top: 38px; right: 12px;">
                        <i v-if="confirmacaoValida" class="bi bi-check-circle-fill" style="color: #28a745;"></i>
                        <i v-else class="bi bi-exclamation-circle-fill" style="color: #dc3545;"></i>
                    </span>
                    <div v-if="confirmacaoValida" class="text-success small mt-1">Confirmação válida.</div>
                    <div v-else-if="confirmacaoTocada && validaConfirmacaoSenha" class="text-danger small mt-1">
                        {{ validaConfirmacaoSenha }}
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <router-link to="/login" class="btn btn-outline-light"
                                 style="border-color:#0dc9ee;color:#0dc9ee;transition:all 0.3s ease;"
                                 onmouseover="this.style.background='linear-gradient(90deg,#0dc9ee,#0d6dfb)'; this.style.color='#111827'; this.style.fontWeight='bold'; this.style.border='none';"
                                 onmouseout="this.style.background='transparent'; this.style.color='#0dc9ee'; this.style.fontWeight='normal'; this.style.border='1px solid #0dc9ee';"
                    > Voltar
                    </router-link>
                    <button type="submit" class="btn"
                            style="background:linear-gradient(90deg,#0dc9ee,#0d6dfb);border:none;color:#111827;font-weight:bold;">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useRegister} from './useRegister'

const {
    name, email, password, password_confirmation,
    showPassword, showPasswordConfirm,
    togglePassword, togglePasswordConfirm,
    register,
    validaEmail, validaPassword, validaConfirmacaoSenha,
    senhaTocada, confirmacaoTocada, emailTocado, nameTocado,
    nameValido, emailValido, senhaValida, confirmacaoValida
} = useRegister()
</script>

