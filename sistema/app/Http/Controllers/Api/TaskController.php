<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Task;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class TaskController extends Controller
    {
        public function index(Request $request)
        {
            try {
                $tasks = Task::where('user_id', $request->user()->id)->get();
                return response()->json($tasks);
            } catch (\Throwable $e) {
                Log::error('Erro ao listar tarefas: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar tarefas.'], 500);
            }
        }

        public function update(Request $request, $id)
        {
            try {
                $task = Task::findOrFail($id);

                $request->validate([
                    'titulo' => 'required|string|max:255',
                    'descricao' => 'nullable|string',
                    'status' => 'required|in:pendente,em_progresso,completo',
                    'prioridade' => 'nullable|string'
                ]);

                $task->update($request->all());

                return response()->json(['message' => 'Tarefa atualizada com sucesso']);
            } catch (\Throwable $e) {
                Log::error("Erro ao atualizar tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao atualizar a tarefa.'], 500);
            }
        }

        public function store(Request $request)
        {
            try {
                $data = $request->validate([
                    'titulo' => 'required|string|max:255',
                    'descricao' => 'nullable|string',
                    'status' => 'required|in:pendente,em_progresso,completo',
                    'prioridade' => 'nullable|string'
                ]);

                $data['user_id'] = auth()->id();

                $task = Task::create($data);

                return response()->json($task, 201);
            } catch (\Throwable $e) {
                Log::error('Erro ao criar tarefa: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao criar a tarefa.'], 500);
            }
        }

        public function show($id, Request $request)
        {
            try {
                $task = Task::where('id', $id)
                    ->where('user_id', $request->user()->id)
                    ->firstOrFail();

                return response()->json($task);
            } catch (\Throwable $e) {
                Log::error("Erro ao exibir tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao buscar a tarefa.'], 500);
            }
        }

        public function destroy($id)
        {
            try {
                $task = Task::find($id);

                if ( ! $task) {
                    return response()->json(['message' => 'Tarefa não encontrada.'], 404);
                }

                $task->delete();

                return response()->json(['message' => 'Tarefa deletada com sucesso.']);
            } catch (\Throwable $e) {
                Log::error("Erro ao deletar tarefa {$id}: " . $e->getMessage());
                return response()->json(['erro' => 'Erro ao deletar a tarefa.'], 500);
            }
        }
    }
