import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { getUserProfile } from '@/services/userService';
import type { User } from '@/models/User';
import web from '@/services/web';

const userName = ref<string | null>(null);
const userAvatar = ref<string | null>(null);
const usuario = ref<User | null>(null);

export function setupNavBar() {
    const router = useRouter();

    async function carregarUsuario() {
        try {
            const user = await getUserProfile();
            usuario.value = user;
            userName.value = user.name || null;
            userAvatar.value = user.avatar ? `${web.defaults.baseURL}/storage/${user.avatar}` : null;
        } catch (error) {
            console.error('Erro ao carregar usuário da API:', error);
        }
    }

    const logout = async () => {
        try {
            await axios.post('/logout', {}, { withCredentials: true });
        } catch (error) {
            console.warn('Erro ao fazer logout (ignorado):', error);
        }

        try {
            await router.push('/login');
            window.location.reload();
        } catch (e) {
            console.error('Erro ao redirecionar após logout:', e);
        }
    };

    return {
        usuario,
        userName,
        userAvatar,
        carregarUsuario,
        logout
    };
}
