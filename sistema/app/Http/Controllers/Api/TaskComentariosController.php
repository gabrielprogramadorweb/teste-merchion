<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\TaskComentarios;
    use Illuminate\Http\Request;

    class TaskComentariosController extends Controller
    {
        public function index()
        {
            return TaskComentarios::with('user')->orderBy('created_at', 'desc')->get();
        }

        public function store(Request $request)
        {
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
        }

        public function getComentariosPorTask($id)
        {
            $comentarios = TaskComentarios::with('user')
                ->where('task_id', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json($comentarios);
        }
    }
