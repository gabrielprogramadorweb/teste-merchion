<?php
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\TaskComentarioRequest;
    use App\Services\TaskComentarioService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;

    class TaskComentariosController extends Controller
    {
        public function __construct(protected TaskComentarioService $service) {}

        public function index(): JsonResponse
        {
            try {
                return response()->json($this->service->getAll());
            } catch (\Throwable $e) {
                Log::error('Erro ao listar comentários: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar comentários.'], 500);
            }
        }

        public function store(TaskComentarioRequest $request): JsonResponse
        {
            try {
                $comentario = $this->service->store($request->validated(), $request->user()->id);
                return response()->json($comentario, 201);
            } catch (\Throwable $e) {
                Log::error('Erro ao salvar comentário: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao salvar o comentário.'], 500);
            }
        }

        public function getComentariosPorTask(int $id): JsonResponse
        {
            try {
                return response()->json($this->service->getByTaskId($id));
            } catch (\Throwable $e) {
                Log::error("Erro ao buscar comentários da tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar comentários da tarefa.'], 500);
            }
        }
    }
