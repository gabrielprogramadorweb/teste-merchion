<template>
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
        <div class="card shadow p-4" style="max-width:500px;width:100%;background-color:transparent;border: 1px solid #0dc9ee;">
            <div class="mb-3">
                <i class="bi bi-person-check-fill display-4" style="color:#0dc9ee;"></i>
            </div>
            <h1 class="h3 fw-bold text-white">Olá, Seja Bem vindo!</h1>
            <p class="text-white">Você está autenticado com sucesso!</p>
            <router-link to="/tasks">
                <button class="btn btn-info mt-3 px-4 py-2 fw-semibold shadow-sm" style="color:#111827;">
                    Ir para área Kanban
                </button>

            </router-link>

        </div>
    </div>
</template>

<script lang="ts" setup>
</script>
<script setup lang="ts">
</script>
