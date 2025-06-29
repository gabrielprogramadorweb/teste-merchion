import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { getUserProfile } from '@/services/userService';
import web from '@/services/web';

const userName = ref<string | null>(null);
const userAvatar = ref<string | null>(null);
const menuAberto = ref(false);

export function setupNavBar() {
    const router = useRouter();

    async function carregarUsuario() {
        try {
            const user = await getUserProfile();
            userName.value = user.name || null;
            userAvatar.value = user.avatar ? `${web.defaults.baseURL}/storage/${user.avatar}` : null;
        } catch (error: any) {
            if (error.response?.status === 401) {
                console.warn('Usuário não autenticado, redirecionando para login...');
                await router.push('/login');
            } else {
                console.error('Erro ao carregar usuário da API:', error);
            }
        }
    }

    const logout = async () => {
        try {
            await web.post('/logout');
        } catch (error) {
            console.warn('Erro ao fazer logout (ignorado):', error);
        }

        try {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            await router.push('/login');
            window.location.reload();
        } catch (e) {
            console.error('Erro ao redirecionar após logout:', e);
        }
    };
    function toggleMenu() {
        menuAberto.value = !menuAberto.value;
    }

    return {
        userName,
        userAvatar,
        carregarUsuario,
        logout,
        menuAberto,
        toggleMenu
    };
}
