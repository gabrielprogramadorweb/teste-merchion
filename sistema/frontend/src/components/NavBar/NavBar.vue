<template>
    <nav class="navbar navbar-expand-lg bg-dark px-4 py-3 shadow-sm border-bottom border-secondary-subtle">
        <div class="container-fluid d-flex align-items-center justify-between">
            <router-link class="navbar-brand d-flex align-items-center text-info fw-bold fs-5" to="/"><i class="bi bi-kanban-fill fs-4 me-2 text-primary"></i> FlowTask</router-link>

            <div class="d-flex align-items-center gap-3">
                <template v-if="!userName">
                    <router-link to="/login" class="btn btn-outline-light px-3 py-2 fw-semibold"><i class="bi bi-box-arrow-in-right me-1"></i> Entrar</router-link>
                    <router-link to="/register" class="btn btn-light text-dark px-3 py-2 fw-semibold"><i class="bi bi-person-plus-fill me-1"></i> Registrar</router-link>
                </template>

                <template v-else>
                    <router-link to="/tasks" class="btn btn-outline-info fw-semibold px-3 py-2 d-flex align-items-center"><i class="bi bi-list-check me-2"></i> Minhas Tarefas</router-link>

                    <div class="dropdown">
                        <button class="btn btn-dark border-0 d-flex align-items-center gap-2 fw-semibold" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://i.pravatar.cc/32" class="rounded-circle border border-light-subtle" width="32" height="32" alt="Avatar" />
                            <span class="text-light">{{ userName }}</span>
                            <i class="bi bi-caret-down-fill text-light small"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm" aria-labelledby="userDropdown">
                            <li><router-link class="dropdown-item" to="/profile"><i class="bi bi-person-gear me-2"></i> Editar Perfil</router-link></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item text-danger" href="#" @click.prevent="logout"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                        </ul>
                    </div>
                </template>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { setupNavBar } from './Navbar.ts';

const { userName, logout, carregarUsuario } = setupNavBar();

onMounted(() => {
    carregarUsuario();

    const dropdownEl = document.querySelector('[data-bs-toggle="dropdown"]');
    if (dropdownEl && window.bootstrap) {
        new (window.bootstrap as any).Dropdown(dropdownEl);
    }
});
</script>

