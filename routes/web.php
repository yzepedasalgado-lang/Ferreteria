<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
Route::resource('empleados', EmpleadoController::class);

Route::get('/hola', function () {
    return ('hola mundo programacion wweb');
});

Route::get('/hola2', function () {
    return view('prueba', [
        'empresa' => 'Ferretería La Bendición24'
    ]);

    
});
use App\Http\Controllers\ProductoController;
Route::resource('productos', ProductoController::class);
Route::get('/', function () {
    return redirect()->route('productos.index');
});
