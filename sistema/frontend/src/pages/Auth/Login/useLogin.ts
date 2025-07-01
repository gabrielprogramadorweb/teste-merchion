import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import web from '@/services/web'
import { useToast, POSITION } from 'vue-toastification'

export function useLogin() {
    const email = ref('')
    const password = ref('')
    const showPassword = ref(false)
    const router = useRouter()
    const toast = useToast()

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

    const login = async () => {
        if (!isEmailValid.value) {
            toast.warning('O e-mail deve ser do tipo nome@flowtask.com', {
                timeout: 4000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        if (!isPasswordValid.value) {
            toast.warning('A senha deve ter no mínimo 8 caracteres, incluindo maiúscula, minúscula, número e caractere especial.', {
                timeout: 5000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        try {
            await web.get('/sanctum/csrf-cookie', {
                withCredentials: true
            })

            const response = await api.post('/login', {
                email: email.value,
                password: password.value
            }, {
                withCredentials: true
            })

            const token = response.data.token

            const userData = {
                id: response.data.user.id,
                name: response.data.user.name,
                email: response.data.user.email
            }

            localStorage.setItem('token', token)
            localStorage.setItem('user', JSON.stringify(userData))

            router.push('/').then(() => window.location.reload())
        } catch (error: any) {
            const message = error?.response?.data?.message || 'Erro desconhecido'

            if (message.toLowerCase().includes('credenciais')) {
                toast.error('E-mail ou senha incorretos.', {
                    timeout: 5000,
                    position: POSITION.TOP_RIGHT
                })
            } else {
                toast.error('Erro ao fazer login: ' + message, {
                    timeout: 5000,
                    position: POSITION.TOP_RIGHT
                })
            }
        }
    }

    return {
        email,
        password,
        showPassword,
        login,
        isEmailValid,
        isPasswordValid
    }
}
