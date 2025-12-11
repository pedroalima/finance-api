<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/users', [UserController::class, 'store']);      // registrar
Route::post('/auth/login', [UserController::class, 'login']); // login

// Rotas privadas
Route::middleware('auth:sanctum')->group(function () {

    // CRUD de transações
    Route::apiResource('transactions', TransactionController::class);

    // CRUD de usuários (menos o store, que é público)
    Route::apiResource('users', UserController::class)->except(['store']);

    // Dados do usuário logado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
