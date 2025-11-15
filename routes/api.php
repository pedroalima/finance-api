<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/transactions' , [TransactionController::class, 'index']);
Route::get('/transactions/{id}', [TransactionController::class, 'show']);
Route::post('/transactions' , [TransactionController::class, 'store']);
Route::put('/transactions/{id}' , [TransactionController::class, 'update']);
Route::delete('/transactions/{id}' , [TransactionController::class, 'destroy']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
