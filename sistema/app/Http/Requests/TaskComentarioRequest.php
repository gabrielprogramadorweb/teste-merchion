<?php
    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class TaskComentarioRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'task_id' => 'required|exists:tasks,id',
                'comentario' => 'required|string|max:1000',
            ];
        }
    }
