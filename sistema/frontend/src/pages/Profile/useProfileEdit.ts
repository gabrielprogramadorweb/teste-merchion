import {ref, computed, onMounted} from 'vue';
import {Cropper} from 'vue-advanced-cropper';
import {getUserProfile, updateUserProfile} from '@/services/userService';
import {useToast} from 'vue-toastification';
import web from '@/services/web';

export function useProfileEdit() {
    const name = ref('');
    const usuario = ref<any>(null);
    const baseURL = web.defaults.baseURL;
    const loading = ref(false);
    const toast = useToast();
    const image = ref<string | null>(null);
    const preview = ref<string | null>(null);
    const croppedBlob = ref<Blob | null>(null);
    const showModal = ref(false);
    const cropper = ref<InstanceType<typeof Cropper> | null>(null);

    const avatarSrc = computed(() =>
        preview.value || (usuario.value?.avatar ? `${baseURL}/storage/${usuario.value.avatar}` : '/imagens/icon-user.png')
    );

    onMounted(async () => {
        try {
            usuario.value = await getUserProfile();
            name.value = usuario.value.name;
        } catch (error) {
            toast.error('Erro ao carregar perfil do usuário.');
            console.error(error);
        }
    });

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
                    croppedBlob.value = blob;
                    preview.value = URL.createObjectURL(blob);
                    showModal.value = false;
                }
            }, 'image/jpeg');
        }
    }

    function closeModal() {
        showModal.value = false;
    }

    async function submitForm() {
        loading.value = true;

        const form = new FormData();
        form.append('name', name.value);
        if (croppedBlob.value) {
            form.append('avatar', croppedBlob.value, 'avatar.jpg');
        }

        try {
            await updateUserProfile(form);
            toast.success('Perfil atualizado com sucesso!');
            setTimeout(() => {
                window.location.reload();
            }, 4000);
        } catch (e: any) {
            console.error('Erro ao atualizar perfil', e);
            if (e.response?.status === 422 && e.response?.data?.errors) {
                const errors = e.response.data.errors;
                const firstError = Object.values(errors)[0];
                toast.error(firstError as string);
            } else {
                toast.error('Erro ao atualizar o perfil. Tente novamente.');
            }
        } finally {
            loading.value = false;
        }
    }

    return {
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
    };
}
