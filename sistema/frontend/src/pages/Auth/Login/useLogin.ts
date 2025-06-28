import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import web from '@/services/web'

export function useLogin() {
    const email = ref('')
    const password = ref('')
    const showPassword = ref(false)
    const router = useRouter()

    const login = async () => {
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
            alert('Erro ao fazer login: ' + (error?.response?.data?.message || 'Erro desconhecido'))
        }
    }

    return {
        email,
        password,
        showPassword,
        login
    }
}
