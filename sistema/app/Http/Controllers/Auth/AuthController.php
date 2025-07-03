<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Auth\LoginRequest;
    use App\Http\Requests\Auth\RegisterRequest;
    use App\Services\AuthService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class AuthController extends Controller
    {
        public function __construct(protected AuthService $service) {}

        public function login(LoginRequest $request): JsonResponse
        {
            try {
                return response()->json($this->service->login($request));
            } catch (\Throwable $e) {
                Log::error('Erro no login: ' . $e->getMessage());
                return response()->json(['message' => 'Erro interno no servidor.'], 500);
            }
        }

        public function register(RegisterRequest $request): JsonResponse
        {
            try {
                return response()->json($this->service->register($request), 201);
            } catch (\Throwable $e) {
                Log::error('Erro no registro de usuário', [
                    'erro' => $e->getMessage(),
                    'linha' => $e->getLine(),
                    'arquivo' => $e->getFile(),
                ]);
                return response()->json(['message' => 'Erro interno ao registrar.'], 500);
            }
        }

        public function logout(Request $request): JsonResponse
        {
            try {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'Logout realizado com sucesso.']);
            } catch (\Throwable $e) {
                Log::error('Erro no logout: ' . $e->getMessage());
                return response()->json(['message' => 'Erro ao realizar logout.'], 500);
            }
        }
    }

