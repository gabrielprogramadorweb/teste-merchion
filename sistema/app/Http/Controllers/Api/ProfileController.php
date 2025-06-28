<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Http\JsonResponse;

    class ProfileController extends Controller
    {
        public function edit(): JsonResponse
        {
            return response()->json(auth()->user());
        }

        public function update(Request $request): JsonResponse
        {
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
        }

        public function destroy(Request $request): JsonResponse
        {
            $request->validate([
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Conta excluída com sucesso.']);
        }
    }
