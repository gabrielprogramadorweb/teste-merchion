<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;

    class ProfileController extends Controller
    {
        public function edit(): JsonResponse
        {
            try {
                return response()->json(auth()->user());
            } catch (\Throwable $e) {
                Log::error('Erro ao carregar perfil: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao carregar o perfil.'], 500);
            }
        }

        public function update(Request $request): JsonResponse
        {
            try {
                $user = auth()->user();

                $request->validate([
                    'name' => 'required|string|max:255',
                    'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                ]);

                $user->name = $request->name;

                if ($request->hasFile('avatar')) {
                    if ($user->avatar && Storage::exists($user->avatar)) {
                        Storage::delete($user->avatar);
                    }

                    $user->avatar = $request->file('avatar')->store('avatars', 'public');
                }

                $user->save();

                return response()->json([
                    'message' => 'Perfil atualizado com sucesso!',
                    'user' => $user
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

                $user = $request->user();

                Auth::logout();

                $user->delete();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json(['message' => 'Conta excluída com sucesso.']);
            } catch (\Throwable $e) {
                Log::error('Erro ao excluir conta: ' . $e->getMessage());
                return response()->json(['erro' => 'Erro ao excluir a conta.'], 500);
            }
        }
    }
