<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota que exibe o formulário de nova senha
Route::get('/password/reset/{token}', function (Request $request, $token) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->email
    ]);
})->name('password.reset');

// Rota que processa a nova senha (POST)
Route::post('/password/reset', [UserController::class, 'updatePassword'])
    ->name('password.update');
