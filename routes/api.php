<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\clienteController;
use App\Model\Clientes;


Route::get('/Clientes', [clienteController::class, 'mostrar']);

Route::get('/Clientes/{id}',  [clienteController::class, 'buscar']);

Route::post('/Clientes', [clienteController::class, 'crear']);

Route::put('/Clientes/{id}', [clienteController::class, 'actualizar']);

Route::patch('/Clientes/{id}', [clienteController::class, 'actualizacionParcial']);

Route::delete('/Clientes/{id}', [clienteController::class, 'eliminar']);