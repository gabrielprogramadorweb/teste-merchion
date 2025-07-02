<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\ValidationException;

    class AuthController extends Controller
    {
        public function login(Request $request)
        {
            try {
                $credentials = $request->only('email', 'password');

                if ( ! Auth::attempt($credentials)) {
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
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:6|confirmed',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ]);

                return response()->json([
                    'token' => $user->createToken('token')->plainTextToken,
                    'user' => $user,
                ], 201);
            } catch (\Throwable $e) {
                Log::error(
                    'Erro no registro de usuário',
                    ['erro' => $e->getMessage(), 'linha' => $e->getLine(), 'arquivo' => $e->getFile(),]
                );
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }

    }
