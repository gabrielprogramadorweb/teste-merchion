<?php
    namespace App\Services;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Session;

    class AuthService
    {
        public function login(Request $request): array
        {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                abort(401, 'Credenciais inválidas');
            }

            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;

            Session::put('id', $user->id);
            Session::put('name', $user->name);
            Session::put('email', $user->email);

            return [
                'message' => 'Login efetuado com sucesso',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
        }

        public function register(Request $request): array
        {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            return [
                'token' => $user->createToken('token')->plainTextToken,
                'user' => $user,
            ];
        }
    }
