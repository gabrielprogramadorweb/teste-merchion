<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\TaskComentarios;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class TaskComentariosController extends Controller
    {
        public function index()
        {
            try {
                return TaskComentarios::with('user')->orderBy('created_at', 'desc')->get();
            } catch (\Throwable $e) {
                Log::error('Erro ao listar comentários: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar comentários.'], 500);
            }
        }

        public function store(Request $request)
        {
            try {
                $request->validate([
                    'task_id' => 'required|exists:tasks,id',
                    'comentario' => 'required|string|max:1000',
                ]);

                $comentario = TaskComentarios::create([
                    'task_id' => $request->task_id,
                    'comentario' => $request->comentario,
                    'user_id' => auth()->id(),
                ]);

                return response()->json($comentario->load('user'), 201);
            } catch (\Throwable $e) {
                Log::error('Erro ao salvar comentário: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao salvar o comentário.'], 500);
            }
        }

        public function getComentariosPorTask($id)
        {
            try {
                $comentarios = TaskComentarios::with('user')
                    ->where('task_id', $id)
                    ->orderBy('created_at', 'asc')
                    ->get();

                return response()->json($comentarios);
            } catch (\Throwable $e) {
                Log::error("Erro ao buscar comentários da tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar comentários da tarefa.'], 500);
            }
        }
    }
