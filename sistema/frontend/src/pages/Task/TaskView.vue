<template>
    <div class="container" style="margin-top:100px;background-color:#111827">
    <div class="d-flex justify-content-between align-items-center mb-3" style="background-color:#111827">
            <h2 class="text-white fw-semibold fs-4">Minhas Tarefas</h2>
            <button class="btn btn-success btn-sm px-3 py-2" @click="abrirModal">
                <i class="bi bi-plus-lg me-1"></i> Criar
            </button>
        </div>

        <div class="row">
            <div class="col-md-4" v-for="status in statusList" :key="status.value">
                <div style="background-color:#111827;color:#f1f5f9;border:1px solid #00ffa3;" class="rounded-3 shadow-sm p-3 mb-4">
                    <h6 class="text-center text-white fw-semibold mb-3">
                        <i :class="status.icon" class="me-1"></i>
                        {{ status.label }}
                    </h6>

                    <div v-for="task in tasksPorStatus(status.value)" :key="task.id" class="shadow-sm rounded-3 small" style="background-color:#111827;color:#f1f5f9;margin-bottom:18px;padding:14px;border:1px solid #334155;">
                        <h6 class="fw-semibold mb-1" style="color:#fff;">{{ task.titulo }}</h6>
                        <p class="mb-2 small text-light">{{ task.descricao }}</p>
                        <hr class="my-2" style="border:1px solid #00ffa3;" />
                        <div>
                            <small class="text-white">Comentários</small>
                            <div
                                v-for="comentario in comentariosPorTask(task.id)"
                                :key="comentario.id"
                                class="mb-1 text-white small"
                            >
                                <i class="bi bi-chat-left-dots-fill me-1 text-white"></i>
                                <strong>{{ comentario.user?.name || 'Usuário' }}:</strong> {{ comentario.comentario }}
                            </div>

                            <div class="input-group input-group-sm mt-2">
                                <input
                                    v-model="novoComentario[task.id]"
                                    type="text"
                                    class="form-control"
                                    placeholder="Comentar..."
                                    style="background-color:#1f2937;border:1px solid #00ffa3;color:#f8fafc;"
                                >
                                <button class="btn btn-outline-primary" @click="adicionarComentario(task.id)">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button @click="editarTask(task)" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button @click="abrirModalExclusao(task.id!)" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>

                    <div v-if="tasksPorStatus(status.value).length === 0" class="text-gray-400 text-center fst-italic small mt-3">
                        Nenhuma tarefa
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color:#111827;color:#f1f5f9;">
                    <form @submit.prevent="salvarTask">
                        <div class="modal-header" style="border-bottom:1px solid #334155;">
                            <h5 class="modal-title">
                                <i class="bi bi-ui-checks-grid me-1"></i>
                                {{ form.id ? 'Editar' : 'Nova' }} Tarefa
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" style="filter: invert(1);"></button>
                        </div>
                        <div class="modal-body">
                            <input v-model="form.titulo" type="text" class="form-control mb-3" placeholder="Título" required style="background-color:#1f2937;border:1px solid #334155;color:#f8fafc;">
                            <textarea v-model="form.descricao" class="form-control mb-3" placeholder="Descrição" rows="3" style="background-color:#1f2937;border:1px solid #334155;color:#f8fafc;"></textarea>
                            <select v-model="form.status" class="form-select" style="background-color:#1f2937;border:1px solid #334155;color:#f8fafc;">
                                <option value="pendente">Pendente</option>
                                <option value="em_progresso">Em Progresso</option>
                                <option value="completo">Completo</option>
                            </select>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid #334155;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                {{ form.id ? 'Atualizar' : 'Salvar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color:#111827; color:#f1f5f9;">
                    <div class="modal-header bg-danger text-white" style="border-bottom:1px solid #dc3545;">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Exclusão
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" style="filter: invert(1);"></button>
                    </div>
                    <div class="modal-body">Tem certeza que deseja excluir esta tarefa?</div>
                    <div class="modal-footer" style="border-top:1px solid #dc3545;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" @click="confirmarExclusao">
                            <i class="bi bi-trash me-1"></i> Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import {
    comentarios,
    novoComentario,
    comentariosPorTask,
    adicionarComentario,
    form,
    statusList,
    salvarTask,
    editarTask,
    abrirModal,
    tasksPorStatus,
    carregarTasks,
    abrirModalExclusao,
    confirmarExclusao,
    inicializarModalExclusao
} from './Task';

import { onMounted } from 'vue';

onMounted(async () => {
    inicializarModalExclusao();
    await carregarTasks();
});
</script>
