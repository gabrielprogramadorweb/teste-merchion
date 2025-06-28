import { ref, onMounted } from 'vue';
import { getUserProfile, updateUserProfile } from '@/services/userService';
import { useToast } from 'vue-toastification';

export function useProfileEdit() {
    const name = ref('');
    const avatarFile = ref<File | null>(null);
    const loading = ref(false);
    const success = ref(false);
    const toast = useToast();

    onMounted(async () => {
        const user = await getUserProfile();
        name.value = user.name;
    });

    async function submitForm() {
        loading.value = true;
        const form = new FormData();
        form.append('name', name.value);
        if (avatarFile.value) form.append('avatar', avatarFile.value);

        try {
            await updateUserProfile(form);
            success.value = true;
            toast.success('Perfil atualizado com sucesso!');
            setTimeout(() => {
                window.location.reload();
            }, 4000);
        } catch (e) {
            console.error('Erro ao atualizar perfil', e);
            toast.error('Erro ao atualizar o perfil. Tente novamente.');
        } finally {
            loading.value = false;
        }
    }

    return {
        name,
        avatarFile,
        loading,
        success,
        submitForm,
    };
}
