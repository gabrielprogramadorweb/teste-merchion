<?php
    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class TaskRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'titulo' => 'required|string|max:255',
                'descricao' => 'nullable|string',
                'status' => 'required|in:pendente,em_progresso,completo',
                'prioridade' => 'nullable|string'
            ];
        }
    }
