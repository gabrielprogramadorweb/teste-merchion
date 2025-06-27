<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4 text-primary">Minhas Tarefas</h1>

                <!-- Formulário -->
                <form @submit.prevent="salvarTask" class="card shadow-sm p-4 mb-5">
                    <div class="mb-3">
                        <input
                            v-model="form.titulo"
                            type="text"
                            placeholder="Título"
                            class="form-control"
                        />
                    </div>

                    <div class="mb-3">
            <textarea
                v-model="form.descricao"
                placeholder="Descrição"
                rows="3"
                class="form-control"
            ></textarea>
                    </div>

                    <div class="mb-3">
                        <select v-model="form.status" class="form-select">
                            <option value="pendente">🕓 Pendente</option>
                            <option value="em_progresso">⏳ Em Progresso</option>
                            <option value="completo">✅ Completo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ form.id ? 'Atualizar Tarefa' : 'Salvar Tarefa' }}
                    </button>
                </form>

                <!-- Lista -->
                <div v-if="tasks.length === 0" class="alert alert-info text-center">
                    Nenhuma tarefa encontrada.
                </div>

                <ul class="list-group shadow-sm">
                    <li
                        v-for="task in tasks"
                        :key="task.id"
                        class="list-group-item d-flex justify-content-between align-items-start"
                    >
                        <div class="ms-2 me-auto">
                            <div class="fw-bold text-primary">{{ task.titulo }}</div>
                            <small class="text-muted fst-italic">{{ formatarStatus(task.status) }}</small>
                            <p class="mb-0">{{ task.descricao }}</p>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <button @click="editarTask(task)" class="btn btn-sm btn-outline-primary mb-1">
                                ✏️ Editar
                            </button>
                            <button @click="excluirTask(task.id!)" class="btn btn-sm btn-outline-danger">
                                🗑️ Excluir
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { Task } from '../models/Task';
import * as taskService from '../services/taskService';

const tasks = ref<Task[]>([]);
const form = ref<Task>({
    titulo: '',
    descricao: '',
    status: 'pendente',
    prioridade: 'normal'
});

const carregarTasks = async () => {
    const { data } = await taskService.getTasks();
    tasks.value = data;
};

const salvarTask = async () => {
    if (form.value.id) {
        await taskService.updateTask(form.value);
    } else {
        await taskService.createTask(form.value);
    }
    form.value = { titulo: '', descricao: '', status: 'pendente', prioridade: 'normal' };
    await carregarTasks();
};

const editarTask = (task: Task) => {
    form.value = { ...task };
};

const excluirTask = async (id: number) => {
    await taskService.deleteTask(id);
    await carregarTasks();
};

const formatarStatus = (status: string): string => {
    const mapa: Record<string, string> = {
        pendente: '🕓 Pendente',
        em_progresso: '⏳ Em Progresso',
        completo: '✅ Completo'
    };
    return mapa[status] ?? status;
};

onMounted(() => carregarTasks());
</script>
