import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import  web  from '@/services/web'
export function useRegister() {
    const name = ref('')
    const email = ref('')
    const password = ref('')
    const password_confirmation = ref('')
    const showPassword = ref(false)
    const showPasswordConfirm = ref(false)

    const togglePassword = () => {
        showPassword.value = !showPassword.value
    }

    const togglePasswordConfirm = () => {
        showPasswordConfirm.value = !showPasswordConfirm.value
    }

    const router = useRouter()

    const register = async () => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email.value)) {
            alert('E-mail inválido. Por favor, insira um e-mail válido como "exemplo@dominio.com".');
            return;
        }

        if (password.value !== password_confirmation.value) {
            alert('As senhas não coincidem.');
            return;
        }

        try {
            await web.get('/sanctum/csrf-cookie', { withCredentials: true });

            const response = await axios.post('/api/register', {
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: password_confirmation.value
            });

            localStorage.setItem('token', response.data.token)
            localStorage.setItem('user', JSON.stringify({
                id: response.data.user.id,
                name: response.data.user.name
            }))

            window.location.reload()
        } catch (error: any) {
            console.error('Erro ao registrar:', error);
            const msg = error?.response?.data?.message || 'Erro desconhecido';
            alert('Erro ao registrar: ' + msg);
        }
    }

    return {
        name, email, password, password_confirmation,
        showPassword, showPasswordConfirm,
        togglePassword, togglePasswordConfirm,
        register
    }
}
