import { ref } from 'vue';

export function useAvatarPreview(emit: (event: 'update:avatar', value: Blob) => void) {
    const image = ref<string | null>(null);
    const preview = ref<string | null>(null);
    const showModal = ref(false);
    const cropper = ref();

    function onFileChange(event: Event) {
        const file = (event.target as HTMLInputElement).files?.[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                image.value = reader.result as string;
                showModal.value = true;
            };
            reader.readAsDataURL(file);
        }
    }

    function cropImage() {
        const canvas = cropper.value?.getResult()?.canvas;
        if (canvas) {
            canvas.toBlob((blob: Blob | null) => {
                if (blob) {
                    emit('update:avatar', blob);
                    preview.value = URL.createObjectURL(blob);
                    showModal.value = false;
                }
            }, 'image/jpeg');
        }
    }

    function closeModal() {
        showModal.value = false;
    }

    return {
        image,
        preview,
        showModal,
        cropper,
        onFileChange,
        cropImage,
        closeModal
    };
}
