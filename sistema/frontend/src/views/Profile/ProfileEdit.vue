<template>
    <div class="container mt-4">
        <h2>Editar Perfil</h2>
        <form @submit.prevent="submitForm" class="card p-4 shadow-sm">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input v-model="name" type="text" class="form-control" required />
            </div>

            <AvatarPreview @update:avatar="avatarFile = $event" />

            <button type="submit" class="btn btn-primary" :disabled="loading">
                Salvar Alterações
            </button>
        </form>

        <div v-if="success" class="alert alert-success mt-3">
            Perfil atualizado com sucesso!
        </div>
    </div>
</template>

<script lang="ts" setup>
import AvatarPreview from '@/components/Avatar/AvatarPreview.vue';
import { useProfileEdit } from './useProfileEdit';

const { name, avatarFile, loading, success, submitForm } = useProfileEdit();
</script>
