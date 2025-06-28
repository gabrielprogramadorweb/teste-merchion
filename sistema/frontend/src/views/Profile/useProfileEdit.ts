import { ref, onMounted } from 'vue';
import { getUserProfile, updateUserProfile } from '@/services/userService';

export function useProfileEdit() {
    const name = ref('');
    const avatarFile = ref<File | null>(null);
    const loading = ref(false);
    const success = ref(false);

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
            setTimeout(() => {
                window.location.reload();
            }, 4000);
        } catch (e) {
            console.error('Erro ao atualizar perfil', e);
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
