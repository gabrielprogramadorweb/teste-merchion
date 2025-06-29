<?php

use App\Http\Controllers\Api\ProfileController;
    use App\Http\Controllers\Api\SuporteController;
    use App\Http\Controllers\Api\TaskComentariosController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Tasks
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::get('/comentarios/task/{id}', [TaskComentariosController::class, 'getComentariosPorTask']);

    // TaskComeentarios
    Route::get('/comentarios', [TaskComentariosController::class, 'index']);
    Route::post('/comentarios', [TaskComentariosController::class, 'store']);

    // Profile
    Route::get('/user', [ProfileController::class, 'edit']);
    Route::post('/perfil/editar', [ProfileController::class, 'update']);
    Route::delete('/perfil/deletar', [ProfileController::class, 'destroy']);

    //Suporte
    Route::post('/suporte/responder', [SuporteController::class, 'responder']);


});


