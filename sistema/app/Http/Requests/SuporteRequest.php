<?php
    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class SuporteRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'mensagem' => 'required|string',
            ];
        }
    }
