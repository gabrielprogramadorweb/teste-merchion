<template>
    <div>
        <!-- Botão Chatflutuante -->
        <button @click="abrirModal = true" class="rounded-circle position-fixed d-flex align-items-center justify-content-center" style="bottom:24px;right:24px;width:56px;height:56px;background-color:#0dc9ee;border:none;z-index:9999;">
            <i class="bi bi-chat-dots-fill fs-4 text-white"></i>
        </button>

        <transition name="slide-delay">
            <div v-if="abrirModal" class="position-fixed" style="bottom:90px;right:24px;z-index:10000;">
                <div class="bg-white rounded-4 shadow d-flex flex-column" style="width:90vw;max-width:400px;height:70vh;max-height:500px;overflow:hidden;">
                    <div class="d-flex align-items-center justify-content-between px-3 py-2" style="background-color: #0dc9ee;">
                        <div class="d-flex align-items-center gap-2 text-white">
                            <img src="/imagens/ia-perfil.png" alt="IA" width="30" class="rounded-circle" />
                            <strong>Suporte IA - FlowTask</strong>
                        </div>
                        <button class="btn btn-sm btn-close-white" style="background:transparent;border:none;" @click="abrirModal = false">
                            <i class="bi bi-x-lg text-white"></i>
                        </button>
                    </div>

                <div ref="chatBody" class="flex-grow-1 px-3 py-2 overflow-auto" style="background: #f9f9f9;">
                    <div class="text-muted small text-center my-2">Pergunte qualquer coisa sobre o FlowTask.</div>

                    <div v-for="(msg, i) in mensagens" :key="i" class="mb-2">
                        <div v-if="msg.tipo === 'usuario'" class="d-flex justify-content-end">
                            <div class="bg-primary text-white rounded-pill px-3 py-2" style="max-width: 70%;">
                                <span v-html="msg.texto"></span>
                            </div>
                        </div>
                        <div v-else class="d-flex justify-content-start">
                            <div class="bg-white border rounded px-3 py-2" style="max-width: 70%;">
                                <span v-html="msg.texto"></span>
                            </div>
                        </div>
                    </div>

                    <div v-if="carregando" class="text-muted small text-center">IA está digitando...</div>
                </div>

                    <div class="border-top p-2 d-flex align-items-center" style="background: #fff;">
                        <button class="btn btn-link text-muted p-0 me-2"><i class="bi bi-emoji-smile"></i></button>
                        <button class="btn btn-link text-muted p-0 me-2"><i class="bi bi-paperclip"></i></button>
                        <input v-model="mensagem" @keyup.enter="enviar" :disabled="carregando" placeholder="Qual sua dúvida?" class="form-control border-0" style="flex: 1; background: transparent;"/>
                        <button class="btn p-0 ms-2" :disabled="carregando" @click="enviar">
                            <i class="bi bi-send-fill" :style="{ color: mensagem.trim() ? '#0dc9ee' : '#ccc' }"></i>
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { useSuporteChat } from './useSuporte'

const {
    abrirModal,
    mensagem,
    mensagens,
    carregando,
    chatBody,
    enviar
} = useSuporteChat()
</script>
