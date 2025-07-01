import { ref, computed } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import web from '@/services/web'
import { useToast, POSITION } from 'vue-toastification'

export function useRegister() {
    const name = ref('')
    const email = ref('')
    const password = ref('')
    const password_confirmation = ref('')
    const showPassword = ref(false)
    const showPasswordConfirm = ref(false)

    const toast = useToast()
    const router = useRouter()

    const isEmailValid = computed(() => {
        const regex = /^[^\s@]+@flowtask\.com$/i
        return regex.test(email.value)
    })

    const isPasswordValid = computed(() => {
        return (
            password.value.length >= 8 &&
            /[A-Z]/.test(password.value) &&
            /[a-z]/.test(password.value) &&
            /[0-9]/.test(password.value) &&
            /[\W_]/.test(password.value)
        )
    })

    const togglePassword = () => {
        showPassword.value = !showPassword.value
    }

    const togglePasswordConfirm = () => {
        showPasswordConfirm.value = !showPasswordConfirm.value
    }

    const register = async () => {
        if (!isEmailValid.value) {
            toast.warning('O e-mail deve terminar com @flowtask.com', {
                timeout: 4000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        if (!isPasswordValid.value) {
            toast.warning('A senha deve conter no mínimo 8 caracteres, incluindo maiúscula, minúscula, número e caractere especial.', {
                timeout: 5000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        if (password.value !== password_confirmation.value) {
            toast.warning('As senhas não coincidem.', {
                timeout: 4000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        try {
            await web.get('/sanctum/csrf-cookie', { withCredentials: true })

            const response = await axios.post('/api/register', {
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: password_confirmation.value
            })

            localStorage.setItem('token', response.data.token)
            localStorage.setItem('user', JSON.stringify({
                id: response.data.user.id,
                name: response.data.user.name
            }))

            router.push('/').then(() => window.location.reload())
        } catch (error: any) {
            const msg = error?.response?.data?.message || 'Erro desconhecido'
            toast.error('Erro ao registrar: ' + msg, {
                timeout: 5000,
                position: POSITION.TOP_RIGHT
            })
        }
    }

    return {
        name,
        email,
        password,
        password_confirmation,
        showPassword,
        showPasswordConfirm,
        togglePassword,
        togglePasswordConfirm,
        register,
        isEmailValid,
        isPasswordValid
    }
}
