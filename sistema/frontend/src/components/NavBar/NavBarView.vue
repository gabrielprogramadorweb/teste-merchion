<template>
    <nav class="navbar navbar-expand-lg px-4 py-3 shadow-sm  fixed-top" style="background-color:#1F2937">
    <div class="container-fluid d-flex align-items-center justify-between">
            <router-link class="navbar-brand d-flex align-items-center text-info fw-bold fs-5" to="/"><i class="bi bi-kanban-fill fs-4 me-2 text-primary"></i> FlowTask</router-link>

            <div class="d-flex align-items-center gap-3">
                <template v-if="!userName">
                    <router-link to="/login" class="btn btn-outline-light px-3 py-2 fw-semibold"><i class="bi bi-box-arrow-in-right me-1"></i> Entrar</router-link>
                    <router-link to="/register" class="btn btn-light text-dark px-3 py-2 fw-semibold"><i class="bi bi-person-plus-fill me-1"></i> Registrar</router-link>
                </template>

                <template v-else>
                    <router-link to="/tasks" class="btn btn-outline-info fw-semibold px-3 py-2 d-flex align-items-center"><i class="bi bi-list-check me-2" style="height:28px;"></i>
                        Minhas Tarefas
                    </router-link>
                    <div class="dropdown">
                        <button class="btn btn-transparent d-flex align-items-center gap-2 fw-semibold" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border:1px solid #0dc9ee">
                            <img :src="userAvatar || '/imagens/icon-user.png'" class="rounded-circle" width="32" height="32" alt="Avatar" style="border:1px solid #0dc9ee" />
                            <span class="text-light">{{ userName }}</span>
                            <i class="bi bi-caret-down-fill text-light small"></i>
                        </button>

                        <ul class="dropdown-menu custom-dropdown mt-2 shadow" aria-labelledby="userDropdown">
                            <li>
                                <router-link class="dropdown-item custom-dropdown-item" to="/perfil/editar">
                                    <i class="bi bi-person-gear me-2"></i> Editar Perfil
                                </router-link>
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a class="dropdown-item custom-dropdown-item text-danger" href="#" @click.prevent="logout">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </div>
                </template>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { setupNavBar } from './useNavbar';

const { userName, userAvatar, usuario, logout, carregarUsuario } = setupNavBar();

onMounted(() => {
    carregarUsuario();

    if (usuario.value?.avatar) {
        userAvatar.value = `/storage/${usuario.value.avatar}`;
    }

    const dropdownEl = document.querySelector('[data-bs-toggle="dropdown"]');
    if (dropdownEl && window.bootstrap) {
        new (window.bootstrap as any).Dropdown(dropdownEl);
    }
});
</script>


