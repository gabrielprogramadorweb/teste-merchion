<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\ValidationException;

    class AuthController extends Controller
    {
        public function login(Request $request)
        {
            try {
                $credentials = $request->only('email', 'password');

                if (!Auth::attempt($credentials)) {
                    return response()->json(['message' => 'Credenciais inválidas'], 401);
                }

                $user = Auth::user();
                $token = $user->createToken('api_token')->plainTextToken;

                Session::put('id', $user->id);
                Session::put('name', $user->name);
                Session::put('email', $user->email);

                return response()->json([
                    'message' => 'Login efetuado com sucesso',
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                ]);
            } catch (\Throwable $e) {
                Log::error('Erro no login: ' . $e->getMessage());
                return response()->json(['message' => 'Erro interno no servidor.'], 500);
            }
        }

        public function logout(Request $request)
        {
            try {
                $request->user()->currentAccessToken()->delete();

                return response()->json(['message' => 'Logout realizado com sucesso.']);
            } catch (\Throwable $e) {
                Log::error('Erro no logout: ' . $e->getMessage());
                return response()->json(['message' => 'Erro ao realizar logout.'], 500);
            }
        }

        public function register(Request $request)
        {
            try {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed',
                ]);

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);

                return response()->json([
                    'token' => $user->createToken('token')->plainTextToken,
                    'user' => $user,
                ]);
            } catch (ValidationException $e) {
                return response()->json(['message' => 'Erro de validação', 'errors' => $e->errors()], 422);
            } catch (\Throwable $e) {
                Log::error('Erro no registro: ' . $e->getMessage());
                return response()->json(['message' => 'Erro interno no servidor.'], 500);
            }
        }
    }
