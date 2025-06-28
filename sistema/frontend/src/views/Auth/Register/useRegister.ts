import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

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
        try {
            await axios.get('http://localhost:8080/sanctum/csrf-cookie', { withCredentials: true });

            const response = await axios.post('/api/register', {
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: password_confirmation.value
            });

            localStorage.setItem('token', response.data.token);
            localStorage.setItem('user', JSON.stringify({
                id: response.data.user.id,
                name: response.data.user.name
            }));

            router.push('/');
        } catch (error: any) {
            alert('Erro ao registrar: ' + (error?.response?.data?.message || 'Erro desconhecido'));
        }
    }

    return {
        name, email, password, password_confirmation,
        showPassword, showPasswordConfirm,
        togglePassword, togglePasswordConfirm,
        register
    }
}
