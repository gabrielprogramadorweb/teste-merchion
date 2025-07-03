<?php
    namespace App\Services;

    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;

    class ProfileService
    {
        public function atualizarPerfil($user, string $name, ?UploadedFile $avatar = null): void
        {
            $user->name = $name;

            if ($avatar) {
                if ($user->avatar && Storage::exists($user->avatar)) {
                    Storage::delete($user->avatar);
                }

                $user->avatar = $avatar->store('avatars', 'public');
            }

            $user->save();
        }

        public function excluirConta($user, $request): void
        {
            auth()->logout();
            $user->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
