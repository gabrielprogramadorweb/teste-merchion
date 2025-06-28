<template>
    <div class="text-center mb-4">
        <div class="avatar-wrapper mx-auto mb-2">
            <img :src="avatarSrc" alt="Avatar" class="avatar-img" />
        </div>

        <label class="btn btn-outline-primary btn-sm">
            Alterar Foto
            <input type="file" accept="image/*" @change="onFileChange" hidden />
        </label>

        <div v-if="showModal" class="modal-backdrop">
            <div class="modal-content">
                <Cropper
                    ref="cropper"
                    :src="image"
                    :stencil-props="{ aspectRatio: 1 }"
                    :auto-zoom="true"
                    :resize-image="true"
                    :background="false"
                    style="max-width: 100%; max-height: 400px"
                />
                <div class="mt-3 text-end">
                    <button class="btn btn-secondary me-2" @click="closeModal">Cancelar</button>
                    <button class="btn btn-primary" @click="cropImage">Recortar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Cropper } from 'vue-advanced-cropper';
import { computed } from 'vue';
import 'vue-advanced-cropper/dist/style.css';
import { useAvatarPreview } from './useAvatarPreview';

const props = defineProps<{
    initialUrl?: string;
}>();

const emit = defineEmits<{
    (e: 'update:avatar', value: Blob): void;
}>();

const {
    image,
    preview,
    showModal,
    cropper,
    onFileChange,
    cropImage,
    closeModal
} = useAvatarPreview(emit);

const defaultAvatar = '/images/avatar-default.png';

const avatarSrc = computed(() => {
    return preview.value || props.initialUrl || defaultAvatar;
});

if (!preview.value && props.initialUrl) {
    preview.value = props.initialUrl;
}
</script>


<style scoped>
.avatar-wrapper {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #6f42c1;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-backdrop {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 500px;
    width: 100%;
}
</style>
