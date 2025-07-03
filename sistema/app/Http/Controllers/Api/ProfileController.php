<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\ProfileUpdateRequest;
    use App\Services\ProfileService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class ProfileController extends Controller
    {
        public function __construct(protected ProfileService $service) {}

        public function edit(): JsonResponse
        {
            try {
                return response()->json(auth()->user());
            } catch (\Throwable $e) {
                Log::error('Erro ao carregar perfil: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao carregar o perfil.'], 500);
            }
        }

        public function update(ProfileUpdateRequest $request): JsonResponse
        {
            try {
                $this->service->atualizarPerfil(
                    auth()->user(),
                    $request->name,
                    $request->file('avatar')
                );

                return response()->json([
                    'message' => 'Perfil atualizado com sucesso!',
                    'user' => auth()->user()
                ]);
            } catch (\Throwable $e) {
                Log::error('Erro ao atualizar perfil: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao atualizar o perfil.'], 500);
            }
        }

        public function destroy(Request $request): JsonResponse
        {
            try {
                $request->validate([
                    'password' => ['required', 'current_password'],
                ]);

                $this->service->excluirConta($request->user(), $request);

                return response()->json(['message' => 'Conta excluída com sucesso.']);
            } catch (\Throwable $e) {
                Log::error('Erro ao excluir conta: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao excluir a conta.'], 500);
            }
        }
    }
