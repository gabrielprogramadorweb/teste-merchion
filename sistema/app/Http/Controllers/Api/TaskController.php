<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Task;

    class TaskController extends Controller
    {
        public function index(Request $request)
        {
            $tasks = Task::where('user_id', $request->user()->id)->get();
            return response()->json($tasks);
        }

        public function update(Request $request, $id)
        {
            $task = Task::findOrFail($id);

            $request->validate([
                'titulo' => 'required|string|max:255',
                'descricao' => 'nullable|string',
                'status' => 'required|in:pendente,em_progresso,completo',
                'prioridade' => 'nullable|string'
            ]);

            $task->update($request->all());

            return response()->json(['message' => 'Tarefa atualizada com sucesso']);
        }

        public function store(Request $request)
        {
            $data = $request->validate([
                'titulo' => 'required|string|max:255',
                'descricao' => 'nullable|string',
            ]);

            $data['user_id'] = auth()->id();

            $task = Task::create($data);

            return response()->json($task, 201);
        }
        public function show($id, Request $request)
        {
            $task = Task::where('id', $id)
                ->where('user_id', $request->user()->id)
                ->firstOrFail();

            return response()->json($task);
        }

        public function destroy($id)
        {
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['message' => 'Tarefa não encontrada.'], 404);
            }

            $task->delete();

            return response()->json(['message' => 'Tarefa deletada com sucesso.']);
        }

    }

