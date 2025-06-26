export interface Task {
    id?: number;
    titulo: string;
    descricao: string;
    status: 'pendente' | 'em_progresso' | 'completo';
    data_vencimento?: string;
    prioridade: 'baixa' | 'normal' | 'alta';
    tags?: string[];
    user_id?: number;
    created_at?: string;
    updated_at?: string;
}
