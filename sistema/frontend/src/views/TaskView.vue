<template>
    <div class="max-w-4xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Minhas Tarefas</h1>

        <form @submit.prevent="salvarTask" class="mb-6">
            <input v-model="form.titulo" placeholder="Título" class="border p-2 w-full mb-2" />
            <textarea v-model="form.descricao" placeholder="Descrição" class="border p-2 w-full mb-2"></textarea>
            <select v-model="form.status" class="border p-2 w-full mb-2">
                <option value="pendente">Pendente</option>
                <option value="em_progresso">Em Progresso</option>
                <option value="completo">Completo</option>
            </select>
            <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">Salvar</button>
        </form>

        <div v-if="tasks.length === 0">Nenhuma tarefa encontrada.</div>
        <ul>
            <li v-for="task in tasks" :key="task.id" class="border-b py-2 flex justify-between">
                <div>
                    <strong>{{ task.titulo }}</strong> - <em>{{ task.status }}</em>
                    <p>{{ task.descricao }}</p>
                </div>
                <div class="space-x-2">
                    <button class="text-blue-600" @click="editarTask(task)">Editar</button>
                    <button class="text-red-600" @click="excluirTask(task.id!)">Excluir</button>
                </div>
            </li>
        </ul>
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

onMounted(() => carregarTasks());
</script>

<style scoped>
/* Adicione estilos se quiser */
</style>
