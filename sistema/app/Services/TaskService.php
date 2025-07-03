<?php
    namespace App\Services;

    use App\Models\Task;

    class TaskService
    {
        public function getUserTasks(int $userId)
        {
            return Task::where('user_id', $userId)->get();
        }

        public function createTask(array $data, int $userId)
        {
            $data['user_id'] = $userId;
            return Task::create($data);
        }

        public function getTaskByIdAndUser(int $id, int $userId)
        {
            return Task::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();
        }

        public function updateTask(int $id, array $data)
        {
            $task = Task::findOrFail($id);
            $task->update($data);
        }

        public function deleteTask(int $id)
        {
            $task = Task::findOrFail($id);
            $task->delete();
        }
    }
