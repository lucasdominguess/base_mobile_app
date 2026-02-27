<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;



Route::get('/test', function (Request $request) {

        Log::channel('telegram')->critical('log telegram ramdom_team_api test');
         return Log::info('log ramdom_team_api test');
});
Route::get('/users', [UserController::class, 'index']);


// Bloqueia automaticamente com 403 se o usuário não passar no Gate 'is-admin'
Route::middleware(['auth:api', 'can:is-admin'])->group(function () {
    Route::post('/users', [UserController::class, 'index']);
});


Route::fallback(fn() => response(["message" => 'Página não encontrada'], 404));

