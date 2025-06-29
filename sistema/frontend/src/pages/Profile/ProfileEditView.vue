<template>
    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card p-4 rounded-4 shadow-lg bg-transparent border border-primary text-white" style="max-width:600px;width:100%;margin-top:100px;">
            <h3 class="mb-4 text-center fw-bold text-info">Editar Perfil</h3>

            <form @submit.prevent="submitForm">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-2 border border-3 border-info rounded-circle overflow-hidden" style="width: 130px; height: 130px;">
                        <img :src="avatarSrc" alt="Avatar" class="w-100 h-100" style="object-fit: cover;" />
                    </div>

                    <label class="btn btn-outline-info btn-sm">
                        Alterar Foto
                        <input type="file" accept="image/*" @change="onFileChange" hidden />
                    </label>

                    <div v-if="showModal" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: rgba(0, 0, 0, 0.6); z-index: 1050;">
                        <div class="bg-white text-dark p-4 rounded-3" style="max-width: 500px; width: 100%;">
                            <Cropper ref="cropper" style="max-width: 100%; max-height: 400px"
                                :src="image"
                                :stencil-props="{ aspectRatio: 1 }"
                                :auto-zoom="true"
                                :resize-image="true"
                                :background="false"
                            />
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-secondary me-2" @click="closeModal">Cancelar</button>
                                <button type="button" class="btn btn-primary" @click="cropImage">Recortar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-4 text-gray-400">
                    <input v-model="name" type="text" class="form-control bg-transparent border border-primary text-white" id="floatingName" placeholder="Nome completo" required/>
                    <label style="color:#0dc9ee;" for="floatingName">Nome completo</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-info btn-lg rounded-pill fw-semibold" :disabled="loading">
                        <i class="bi bi-check-circle me-2"></i>
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useProfileEdit } from './useProfileEdit';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const {
    name,
    avatarSrc,
    image,
    preview,
    croppedBlob,
    showModal,
    cropper,
    loading,
    onFileChange,
    cropImage,
    closeModal,
    submitForm,
} = useProfileEdit();
</script>
