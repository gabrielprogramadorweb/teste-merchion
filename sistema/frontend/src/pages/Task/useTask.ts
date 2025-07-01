import {computed, ref} from 'vue';
import { Task } from '@/models/Task';
import { Comentario } from '@/models/Comentario';
import * as taskService from '@/services/taskService';
import * as comentarioService from '@/services/comentarioService';
import * as bootstrap from 'bootstrap';

export const tasks = ref<Task[]>([]);
export const form = ref<Task>({
    titulo: '',
    descricao: '',
    status: 'pendente',
    prioridade: 'normal'
});

export const statusList = [
    { value: 'pendente', label: 'Pendente', icon: 'bi-clock' },
    { value: 'em_progresso', label: 'Em Progresso', icon: 'bi-tools' },
    { value: 'completo', label: 'Completo', icon: 'bi-check-circle' }
];

export const idTaskParaExcluir = ref<number | null>(null);
let modalExclusao: bootstrap.Modal | null = null;

export const novoComentario = ref<{ [taskId: number]: string }>({});
export const comentarios = ref<Comentario[]>([]);

export const carregarTasks = async () => {
    const { data } = await taskService.getTasks();
    tasks.value = data;

    comentarios.value = [];
    for (const task of tasks.value) {
        const { data: comentariosTask } = await comentarioService.getComentariosPorTask(task.id!);
        comentarios.value.push(...comentariosTask);
    }
};

export const salvarTask = async () => {

    if (form.value.id) {
        await taskService.updateTask(form.value)
    } else {
        await taskService.createTask(form.value)
    }

    await carregarTasks()
    fecharModal()
    resetForm()
}

export const editarTask = (task: Task) => {
    form.value = { ...task };
    abrirModal();
};

export const excluirTask = async (id: number) => {
    await taskService.deleteTask(id);
    await carregarTasks();
};

export const abrirModal = () => {
    const modal = new bootstrap.Modal(document.getElementById('taskModal')!);
    modal.show();
};

const fecharModal = () => {
    const modalEl = document.getElementById('taskModal');
    const modal = bootstrap.Modal.getInstance(modalEl!);
    modal?.hide();
};

const resetForm = () => {
    form.value = { titulo: '', descricao: '', status: 'pendente', prioridade: 'normal' };
};

export const tasksPorStatus = (status: string): Task[] => {
    return tasks.value.filter(task => task.status === status);
};

export const abrirModalExclusao = (id: number) => {
    idTaskParaExcluir.value = id;
    modalExclusao?.show();
};

export const confirmarExclusao = async () => {
    if (idTaskParaExcluir.value !== null) {
        await excluirTask(idTaskParaExcluir.value);
        idTaskParaExcluir.value = null;
    }
    modalExclusao?.hide();
};

export const inicializarModalExclusao = () => {
    const el = document.getElementById('confirmarExclusaoModal');
    if (el) {
        modalExclusao = new bootstrap.Modal(el);
    }
};

export const comentariosPorTask = (taskId: number): Comentario[] => {
    return comentarios.value.filter(c => c.task_id === taskId);
};

export const adicionarComentario = async (taskId: number) => {
    const texto = novoComentario.value[taskId];
    if (!texto?.trim()) return;

    await comentarioService.adicionarComentario({
        task_id: taskId,
        comentario: texto
    });

    novoComentario.value[taskId] = '';
    const { data } = await comentarioService.getComentariosPorTask(taskId);
    comentarios.value = [
        ...comentarios.value.filter(c => c.task_id !== taskId),
        ...data
    ];
};

export const formatarData = (data: string | Date): string => {
    const date = new Date(data);

    const hora = date.toLocaleTimeString('pt-BR', {
        hour: '2-digit',
        minute: '2-digit'
    });

    const dataFormatada = date.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    return `${hora} - ${dataFormatada}`;
};

export const validaTitulo = computed(() => {
    if (!form.value.titulo.trim()) return 'O título é obrigatório.'
    if (form.value.titulo.trim().length < 3) return 'O título deve ter no mínimo 3 caracteres.'
    return ''
})

export const validaDescricao = computed(() => {
    if (!form.value.descricao.trim()) return 'A descrição é obrigatória.'
    if (form.value.descricao.trim().length < 20) return 'A descrição deve ter no mínimo 20 caracteres.'
    return ''
})
