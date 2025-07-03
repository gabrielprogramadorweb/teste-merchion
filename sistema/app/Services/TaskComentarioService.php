<?php
    namespace App\Services;

    use App\Models\TaskComentarios;

    class TaskComentarioService
    {
        public function getAll()
        {
            return TaskComentarios::with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        public function store(array $data, int $userId)
        {
            $data['user_id'] = $userId;

            $comentario = TaskComentarios::create($data);

            return $comentario->load('user');
        }

        public function getByTaskId(int $taskId)
        {
            return TaskComentarios::with('user')
                ->where('task_id', $taskId)
                ->orderBy('created_at', 'asc')
                ->get();
        }
    }
