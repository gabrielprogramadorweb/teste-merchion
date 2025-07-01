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

    const validaEmail = computed(() => {
        if (!email.value.trim()) return 'O e-mail é obrigatório.'
        if (!/^[^\s@]+@flowtask\.com$/i.test(email.value)) {
            return 'O e-mail deve ser do tipo nome@flowtask.com'
        }
        return ''
    })

    const validaPassword = computed(() => {
        if (!password.value) return 'A senha é obrigatória.'
        if (password.value.length < 8) return 'A senha deve ter no mínimo 8 caracteres.'
        if (!/[A-Z]/.test(password.value)) return 'A senha deve conter pelo menos uma letra maiúscula.'
        if (!/[a-z]/.test(password.value)) return 'A senha deve conter pelo menos uma letra minúscula.'
        if (!/[0-9]/.test(password.value)) return 'A senha deve conter pelo menos um número.'
        if (!/[\W_]/.test(password.value)) return 'A senha deve conter pelo menos um caractere especial.'
        return ''
    })

    const validaConfirmacaoSenha = computed(() => {
        if (!password_confirmation.value) return 'Confirme a senha.'
        if (password.value !== password_confirmation.value) return 'As senhas não coincidem.'
        return ''
    })

    const register = async () => {
        if (!name.value.trim()) {
            toast.warning('O nome é obrigatório.', {
                timeout: 4000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        if (validaEmail.value) {
            toast.warning(validaEmail.value, {
                timeout: 4000,
                position: POSITION.TOP_RIGHT
            })
            return
        }

        if (validaPassword.value) {
            toast.warning(validaPassword.value, {
                timeout: 4000,
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
            if (error.response?.status === 422 && error.response.data.errors) {
                const errors = error.response.data.errors
                Object.values(errors).forEach((mensagens: any) => {
                    mensagens.forEach((msg: string) => {
                        toast.error(msg, {
                            timeout: 5000,
                            position: POSITION.TOP_RIGHT
                        })
                    })
                })
            } else {
                const msg = error?.response?.data?.message || 'Erro desconhecido'
                toast.error('Erro ao registrar: ' + msg, {
                    timeout: 5000,
                    position: POSITION.TOP_RIGHT
                })
            }
        }
    }

    return {
        name,
        email,
        password,
        password_confirmation,
        showPassword,
        showPasswordConfirm,
        togglePassword: () => showPassword.value = !showPassword.value,
        togglePasswordConfirm: () => showPasswordConfirm.value = !showPasswordConfirm.value,
        register,
        validaEmail,
        validaPassword,
        validaConfirmacaoSenha
    }
}
