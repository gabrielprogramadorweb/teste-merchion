import { ref, computed } from 'vue'
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

    const validaEmail = computed(() => {
        if (!email.value) return 'O e-mail é obrigatório.'
        if (!/^[^\s@]+@flowtask\.com$/i.test(email.value)) {
            return 'O e-mail deve ser do tipo nome@flowtask.com'
        }
        return ''
    })

    const validaPassword = computed(() => {
        const erros: string[] = []
        if (!password.value) {
            erros.push('A senha é obrigatória.')
        } else {
            if (password.value.length < 8) erros.push('Mínimo de 8 caracteres')
            if (!/[A-Z]/.test(password.value)) erros.push('Letra maiúscula')
            if (!/[a-z]/.test(password.value)) erros.push('Letra minúscula')
            if (!/[0-9]/.test(password.value)) erros.push('Número')
            if (!/[\W_]/.test(password.value)) erros.push('Caractere especial')
        }
        return erros
    })

    const login = async () => {
        if (validaEmail.value) {
            toast.warning(validaEmail.value, { timeout: 4000, position: POSITION.TOP_RIGHT })
            return
        }

        if (validaPassword.value.length > 0) {
            toast.warning('Corrija os erros de senha antes de continuar.', { timeout: 5000, position: POSITION.TOP_RIGHT })
            return
        }

        try {
            await web.get('/sanctum/csrf-cookie', { withCredentials: true })

            const response = await api.post('/login', {
                email: email.value,
                password: password.value
            }, { withCredentials: true })

            const { token, user } = response.data
            localStorage.setItem('token', token)
            localStorage.setItem('user', JSON.stringify(user))

            router.push('/').then(() => window.location.reload())
        } catch (error: any) {
            const message = error?.response?.data?.message || 'Erro desconhecido'

            if (message.toLowerCase().includes('credenciais')) {
                toast.error('E-mail ou senha incorretos.', { timeout: 5000, position: POSITION.TOP_RIGHT })
            } else {
                toast.error('Erro ao fazer login: ' + message, { timeout: 5000, position: POSITION.TOP_RIGHT })
            }
        }
    }

    return {
        email,
        password,
        showPassword,
        login,
        validaEmail,
        validaPassword
    }
}
