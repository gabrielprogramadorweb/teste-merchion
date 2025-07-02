<template>
    <nav class="navbar navbar-expand-lg px-4 py-3 shadow-sm fixed-top" style="background-color:#1F2937">
        <div class="container-fluid">
            <!-- Logo -->
            <router-link class="navbar-brand d-flex align-items-center text-info fw-bold fs-5" to="/">
                <img src="/imagens/flow-task.png" width="50" height="50" alt="Logo FlowTask" class="img-fluid"/>
            </router-link>

            <button class="navbar-toggler text-light border-0" type="button" @click="toggleMenu"
                    aria-label="Toggle navigation">
                <i v-if="!menuAberto" style="color:#0dc9ee;" class="bi bi-list fs-3"></i>
                <i v-else style="color:#0dc9ee;" class="bi bi-x-lg fs-3"></i>
            </button>

            <transition name="slide-delay">
                <div v-if="menuAberto || innerWidth >= 992" class="w-100 mt-3 mt-lg-0" id="navbarContent">
                    <div v-show="menuVisivel || innerWidth >= 992"
                         class="d-flex flex-column flex-lg-row align-items-center justify-content-end gap-3"
                         style="width: 100%;">
                        <template v-if="!userName">
                            <router-link to="/login" class="btn btn-outline-light px-3 py-2 fw-semibold w-auto"
                                         style="border: 1px solid #0dc9ee; color:#0dc9ee;">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                            </router-link>
                            <router-link to="/register"
                                         class="btn btn-outline-light px-3 py-2 w-auto d-flex align-items-center justify-content-center"
                                         style="border: 1px solid #0dc9ee; color:#0dc9ee;--bs-btn-hover-color: #fff; hover-border-color: #fff;">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Registrar
                            </router-link>
                        </template>

                        <template v-else>
                            <router-link to="/tasks"
                                         class="btn btn-outline-info fw-semibold px-3 py-2 d-flex align-items-center w-auto">
                                <i class="bi bi-list-check me-2" style="height:28px;"></i> Minhas Tarefas
                            </router-link>

                            <div class="dropdown">
                                <button type="button" @click="showDropdown = !showDropdown"
                                        class="btn btn-transparent d-flex align-items-center gap-2 fw-semibold flex-nowrap"
                                        style="border: 1px solid #0dc9ee; white-space: nowrap; min-width: max-content;">
                                    <img :src="userAvatar || '/imagens/icon-user.png'" class="rounded-circle" width="32"
                                         height="32" alt="Avatar" style="border: 1px solid #0dc9ee;"/>
                                    <span class="text-light">{{ userName }}</span>
                                    <i :class="showDropdown ? 'bi bi-caret-up-fill' : 'bi bi-caret-down-fill'"
                                       class="text-light small"></i>
                                </button>

                                <ul class="dropdown-menu custom-dropdown mt-2 shadow fade-custom"
                                    :class="{ show: showDropdown }" @click.away="showDropdown = false"
                                    style="display: block;">
                                    <li>
                                        <router-link class="dropdown-item custom-dropdown-item" to="/perfil/editar">
                                            <i class="bi bi-person-gear me-2"></i> Editar Perfil
                                        </router-link>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider"/>
                                    </li>
                                    <li>
                                        <a class="dropdown-item custom-dropdown-item text-danger" href="#"
                                           @click.prevent="logout">
                                            <i class="bi bi-box-arrow-right me-2"></i> Sair
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </template>
                    </div>
                </div>
            </transition>
        </div>
    </nav>
</template>

<script setup lang="ts">
import {onMounted, onUnmounted, ref} from 'vue';
import {setupNavBar} from './useNavbar';

const innerWidth = ref(window.innerWidth);

const {userName, userAvatar, logout, carregarUsuario, menuAberto, toggleMenu} = setupNavBar();
const showDropdown = ref(false);
const handleResize = () => {
    innerWidth.value = window.innerWidth;
};
onMounted(() => {
    window.addEventListener('resize', handleResize);

    carregarUsuario();

    const dropdownEl = document.querySelector('[data-bs-toggle="dropdown"]');
    if (dropdownEl && window.bootstrap) {
        new (window.bootstrap as any).Dropdown(dropdownEl);
    }
});
onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>

