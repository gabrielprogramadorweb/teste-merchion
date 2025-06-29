<template>
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
            <div class="mb-3">
                <i class="bi bi-person-check-fill display-4 text-primary"></i>
            </div>
            <h1 class="h3 fw-bold">Bem-vindo ao Dashboard</h1>
            <p class="text-muted">Você está autenticado com sucesso!</p>
            <router-link to="/tasks">
                <button class="btn btn-primary mt-3">Ir para área Kanban</button>
            </router-link>

        </div>
    </div>
</template>

<script lang="ts" setup>
</script>
