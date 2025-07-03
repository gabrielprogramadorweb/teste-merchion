<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class ProfileUpdateRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ];
        }
    }

