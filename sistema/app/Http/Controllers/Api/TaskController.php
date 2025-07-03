<?php
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\TaskRequest;
    use App\Services\TaskService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class TaskController extends Controller
    {
        public function __construct(protected TaskService $taskService) {}

        public function index(Request $request): JsonResponse
        {
            try {
                $tasks = $this->taskService->getUserTasks($request->user()->id);
                return response()->json($tasks);
            } catch (\Throwable $e) {
                Log::error('Erro ao listar tarefas: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar tarefas.'], 500);
            }
        }

        public function store(TaskRequest $request): JsonResponse
        {
            try {
                $task = $this->taskService->createTask($request->validated(), $request->user()->id);
                return response()->json($task, 201);
            } catch (\Throwable $e) {
                Log::error('Erro ao criar tarefa: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao criar a tarefa.'], 500);
            }
        }

        public function update(TaskRequest $request, int $id): JsonResponse
        {
            try {
                $this->taskService->updateTask($id, $request->validated());
                return response()->json(['message' => 'Tarefa atualizada com sucesso']);
            } catch (\Throwable $e) {
                Log::error("Erro ao atualizar tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao atualizar a tarefa.'], 500);
            }
        }

        public function show(int $id, Request $request): JsonResponse
        {
            try {
                $task = $this->taskService->getTaskByIdAndUser($id, $request->user()->id);
                return response()->json($task);
            } catch (\Throwable $e) {
                Log::error("Erro ao exibir tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar a tarefa.'], 500);
            }
        }

        public function destroy(int $id): JsonResponse
        {
            try {
                $this->taskService->deleteTask($id);
                return response()->json(['message' => 'Tarefa deletada com sucesso.']);
            } catch (\Throwable $e) {
                Log::error("Erro ao deletar tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao deletar a tarefa.'], 500);
            }
        }
    }
