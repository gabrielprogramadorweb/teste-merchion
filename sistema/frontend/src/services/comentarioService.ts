import api from './api';

export function getComentariosPorTask(taskId: number) {
    return api.get(`/comentarios/task/${taskId}`);
}

export function adicionarComentario(data: { task_id: number; comentario: string }) {
    return api.post('/comentarios', data);
}
