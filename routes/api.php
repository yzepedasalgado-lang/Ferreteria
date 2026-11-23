<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\AuthController;


// 1. Rutas Públicas (Cualquiera puede acceder)
Route::post('/login', [AuthController::class, 'login']);

// 2. Rutas Protegidas (Exigen encabezado 'Authorization: Bearer <token>')
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', [AuthController::class, 'perfil']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Operaciones del inventario protegidas
    Route::apiResource('productos', ProductoController::class)->names('api.productos');
});
