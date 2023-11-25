<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('documento')->group(function () {
    Route::prefix('libro-capitulo')->group(function () {
        Route::post('/', 'App\Http\Controllers\DocumentoController@crearLibroCapitulo');
        Route::put('/{documento_id}', 'App\Http\Controllers\DocumentoController@editarLibroCapitulo')->where('documento_id', '[0-9]+');
    });
    Route::get('/{pagina?}', 'App\Http\Controllers\DocumentoController@listarDocumentos')->where('pagina', '[0-9]+');
    Route::delete('/{documento_id}', 'App\Http\Controllers\DocumentoController@eliminarDocumento')->where('documento_id', '[0-9]+');
});
