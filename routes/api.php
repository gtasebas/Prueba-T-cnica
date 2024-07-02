<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\ItemOrdenServicioController;
use App\Http\Controllers\ReporteController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('vehiculos', VehiculoController::class);
Route::apiResource('ordenes-servicio', OrdenServicioController::class);
Route::apiResource('items-orden-servicio', ItemOrdenServicioController::class);
Route::get('reporte', [OrdenServicioController::class, 'reporte']);
Route::post('item-orden-servicio', [ItemOrdenServicioController::class, 'store']);
Route::get('/reporte-ordenes', [ReporteController::class, 'listarOrdenesPorFechaYCliente']);