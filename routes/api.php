<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceTestController;

//Rotas para testar funcionamento dos dispositivos
Route::post('/save_user', [DeviceTestController::class, 'save']);
Route::get('/list_users', [DeviceTestController::class, 'list']);
Route::post('/delete_all', [DeviceTestController::class, 'delete']);
Route::post('/test_vibration', [DeviceTestController::class, 'testVibration']);
Route::post('/test_log_telegram', [DeviceTestController::class, 'testLogTelegram']);



// Bloqueia automaticamente com 403 se o usuário não passar no Gate 'is-admin'
Route::middleware(['auth:api', 'can:is-admin'])->group(function () {
    Route::post('/users', [UserController::class, 'index']);
});

Route::fallback(fn() => response(["message" => 'Página não encontrada'], 404));

