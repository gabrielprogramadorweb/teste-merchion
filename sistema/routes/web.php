<?php

	use App\Http\Controllers\Api\ProfileController;
	use Illuminate\Foundation\Application;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	use Inertia\Inertia;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('web')->get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['csrf' => csrf_token()]);
});

require __DIR__.'/auth.php';
