import { ref, nextTick } from 'vue'
import axios from 'axios'

export function useSuporteChat() {
    const abrirModal = ref(false)
    const mensagem = ref('')
    const mensagens = ref<{ texto: string; tipo: 'usuario' | 'ia' }[]>([])
    const carregando = ref(false)
    const chatBody = ref<HTMLElement | null>(null)
    const mostrarEmojiPicker = ref(false)

    const enviar = async () => {
        const conteudo = mensagem.value.trim()
        if (!conteudo) return

        mensagens.value.push({ texto: conteudo, tipo: 'usuario' })
        mensagem.value = ''
        carregando.value = true

        await nextTick(() => {
            if (chatBody.value) {
                chatBody.value.scrollTop = chatBody.value.scrollHeight
            }
        })

        try {
            const { data } = await axios.post('/api/suporte/responder', { mensagem: conteudo })
            mensagens.value.push({
                texto: formatarNegrito(data.resposta || 'Desculpe, não consegui responder agora.'),
                tipo: 'ia'
            })
        } catch {
            mensagens.value.push({ texto: 'Erro ao se comunicar com a IA.', tipo: 'ia' })
        } finally {
            carregando.value = false
            await nextTick(() => {
                if (chatBody.value) {
                    chatBody.value.scrollTop = chatBody.value.scrollHeight
                }
            })
        }
    }

    function toggleEmojiPicker() {
        mostrarEmojiPicker.value = !mostrarEmojiPicker.value
    }

    function adicionarEmoji(event: any) {
        mensagem.value += event.detail.unicode
        mostrarEmojiPicker.value = false
    }

    function formatarNegrito(texto: string) {
        return texto.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>')
    }

    return {
        abrirModal,
        mensagem,
        mensagens,
        carregando,
        chatBody,
        enviar,
        mostrarEmojiPicker,
        toggleEmojiPicker,
        adicionarEmoji,
    }
}
