<template>
    <nav class="navbar navbar-expand-lg px-4 py-3 shadow-sm fixed-top" style="background-color:#1F2937">
        <div class="container-fluid">
            <!-- Logo -->
            <router-link class="navbar-brand d-flex align-items-center text-info fw-bold fs-5" to="/">
                <img src="/imagens/flow-task.png" width="50" height="50" alt="Logo FlowTask" class="img-fluid" />
            </router-link>

            <button class="navbar-toggler text-light border-0" type="button" @click="toggleMenu" aria-label="Toggle navigation">
                <i v-if="!menuAberto" style="color:#0dc9ee;" class="bi bi-list fs-3"></i>
                <i v-else style="color:#0dc9ee;" class="bi bi-x-lg fs-3"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" :class="{ show: menuAberto }" id="navbarContent">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-3 mt-3 mt-lg-0">
                    <template v-if="!userName">
                        <router-link to="/login" class="btn btn-outline-light px-3 py-2 fw-semibold w-100 w-lg-auto" style="border: 1px solid #0dc9ee; color:#0dc9ee;">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </router-link>
                        <router-link
                            to="/register" class="btn btn-outline-light px-3 py-2 w-100 d-flex align-items-center justify-content-center" style="border: 1px solid #0dc9ee; color:#0dc9ee;--bs-btn-hover-color: #fff; hover-border-color: #fff;">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Registrar
                        </router-link>
                    </template>

                    <template v-else>
                        <router-link to="/tasks" class="btn btn-outline-info fw-semibold px-3 py-2 d-flex align-items-center w-100 w-lg-auto">
                            <i class="bi bi-list-check me-2" style="height:28px;"></i> Minhas Tarefas
                        </router-link>

                        <div class="dropdown">
                            <button type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-transparent d-flex align-items-center gap-2 fw-semibold flex-nowrap" style="border: 1px solid #0dc9ee; white-space: nowrap; min-width: max-content;">
                                <img :src="userAvatar || '/imagens/icon-user.png'" class="rounded-circle" width="32" height="32" alt="Avatar"
                                     style="border: 1px solid #0dc9ee;" />

                                <span class="text-light" style="white-space: nowrap;">{{ userName }}</span>
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
        </div>
    </nav>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { setupNavBar } from './useNavbar';

const {userName, userAvatar, logout, carregarUsuario, menuAberto, toggleMenu} = setupNavBar();

onMounted(() => {
    carregarUsuario();

    const dropdownEl = document.querySelector('[data-bs-toggle="dropdown"]');
    if (dropdownEl && window.bootstrap) {
        new (window.bootstrap as any).Dropdown(dropdownEl);
    }
});
</script>

