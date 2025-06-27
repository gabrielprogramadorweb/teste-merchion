<?php

    use App\Http\Controllers\Api\TaskController;
    use App\Http\Controllers\Auth\AuthController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('tasks', TaskController::class);


    Route::post('/login', function (Request $request) {
        Log::info('Tentando login', [
            'email' => $request->email,
            'password_length' => strlen($request->password),
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            Log::warning('Falha no login');
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $request->session()->regenerate();

        Log::info('Login bem-sucedido', ['user' => Auth::user()->email]);

        return response()->json(['message' => 'Login efetuado com sucesso']);
    });Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
