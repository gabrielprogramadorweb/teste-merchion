import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const userName = ref<string | null>(null);

export function setupNavBar() {
    const router = useRouter();

    function carregarUsuario() {
        const user = localStorage.getItem('user');
        if (user) {
            const parsed = JSON.parse(user);
            userName.value = parsed.name;
            console.log('Usuário logado:', userName.value);
        }
    }

    const logout = async () => {
        try {
            await axios.post('/logout', {}, {
                withCredentials: true
            });
        } catch (error) {
            console.warn('Erro ao fazer logout (ignorado):', error);
        }

        localStorage.removeItem('token');
        localStorage.removeItem('user');

        try {
            await router.push('/login');
            window.location.reload();
        } catch (e) {
            console.error('Erro ao redirecionar após logout:', e);
        }
    };

    return {
        userName,
        logout,
        carregarUsuario
    };
}
