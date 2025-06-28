<template>
    <div class="container d-flex justify-content-center align-items-center" style="margin-top:100px;">
        <div class="card shadow rounded-4 p-4" style="max-width: 600px; width: 100%;">
            <h3 class="mb-4 text-center fw-bold text-primary">Editar Perfil</h3>

            <form @submit.prevent="submitForm">
                <div class="text-center mb-4">
                    <AvatarPreview :initial-url="avatarUrl" @update:avatar="avatarFile = $event" />
                </div>

                <div class="form-floating mb-4">
                    <input v-model="name"type="text"class="form-control rounded-3"id="floatingName" placeholder="Nome completo" required />
                    <label for="floatingName">Nome completo</label>
                </div>

                <!-- Botão salvar -->
                <div class="d-grid">
                    <button type="submit"class="btn btn-primary btn-lg rounded-pill fw-semibold" :disabled="loading">
                        <i class="bi bi-check-circle me-2"></i>
                        Salvar Alterações
                    </button>
                </div>
            </form>

            <div v-if="success" class="alert alert-success mt-4 text-center rounded-pill">
                Perfil atualizado com sucesso!
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import AvatarPreview from '@/components/Avatar/AvatarPreview.vue';
import { useProfileEdit } from './useProfileEdit';
import { getUserProfile } from '@/services/userService';
import web from '@/services/web';

const usuario = ref(null);
const baseURL = web.defaults.baseURL;

onMounted(async () => {
    usuario.value = await getUserProfile();
    name.value = usuario.value.name;
});

const avatarUrl = computed(() =>
    usuario.value?.avatar ? `${baseURL}/storage/${usuario.value.avatar}` : null
);

const { name, avatarFile, loading, success, submitForm } = useProfileEdit();
</script>

