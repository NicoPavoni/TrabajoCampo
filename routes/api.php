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

Route::get('/', function () {
    return response()->json(["status" => "ok"]);
});
Route::post('/login', 'App\Http\Controllers\AuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('certificado-aptitud-tecnica')->group(function () {
        Route::get('/', 'App\Http\Controllers\CATController@todos');
        Route::post('/', 'App\Http\Controllers\CATController@crearCAT');
        Route::put('/{cat_id}', 'App\Http\Controllers\CATController@editarCAT')->where('cat_id', '[0-9]+');
        Route::delete('/', 'App\Http\Controllers\CATController@eliminarCAT')->where('cat_id', '[0-9]+');
        Route::get('/', 'App\Http\Controllers\CATController@verCAT')->where('cat_id', '[0-9]+');
    });

    Route::prefix('documento')->group(function () {
        Route::prefix('libro-capitulo')->group(function () {
            Route::post('/', 'App\Http\Controllers\DocumentoController@crearLibroCapitulo');
            Route::put('/{documento_id}', 'App\Http\Controllers\DocumentoController@editarLibroCapitulo')->where('documento_id', '[0-9]+');
        });
        Route::prefix('revista-nacional')->group(function () {
            Route::post('/', 'App\Http\Controllers\DocumentoController@crearRevistaNacional');
            Route::put('/{documento_id}', 'App\Http\Controllers\DocumentoController@editarRevistaNacional')->where('documento_id', '[0-9]+');
        });
        Route::prefix('articulo-con-referato')->group(function () {
            Route::post('/', 'App\Http\Controllers\DocumentoController@crearArticuloConReferato');
            Route::put('/{documento_id}', 'App\Http\Controllers\DocumentoController@editarArticuloConReferato')->where('documento_id', '[0-9]+');
        });
        Route::prefix('documento-tecnico')->group(function () {
            Route::post('/', 'App\Http\Controllers\DocumentoController@crearDocumentoTecnico');
            Route::put('/{documento_id}', 'App\Http\Controllers\DocumentoController@editarDocumentoTecnico')->where('documento_id', '[0-9]+');
        });

        Route::get('/{tipo_documento}', 'App\Http\Controllers\DocumentoController@listarDocumentos')->where('tipo_documento', '1|2|3|4');
        Route::get('/ver/{documento_id}', 'App\Http\Controllers\DocumentoController@verDocumento')->where('tipo_documento', '[0-9]+');
        Route::delete('/{documento_id}', 'App\Http\Controllers\DocumentoController@eliminarDocumento')->where('documento_id', '[0-9]+');
    });

    Route::prefix('reunion-cientifica')->group(function () {
        Route::get('/', 'App\Http\Controllers\ReunionCientificaController@listarReunionesCientificas');
        Route::post('/', 'App\Http\Controllers\ReunionCientificaController@crearReunionCientifica');
        Route::put('/{reunion_id}', 'App\Http\Controllers\ReunionCientificaController@editarReunionCientifica')->where('reunion_id', '[0-9]+');
        Route::get('/{reunion_id}', 'App\Http\Controllers\ReunionCientificaController@verReunion')->where('reunion_id', '[0-9]+');
        Route::delete('/{reunion_id}', 'App\Http\Controllers\ReunionCientificaController@eliminarReunionCientifica')->where('reunion_id', '[0-9]+');
    });

    Route::prefix('evento')->group(function () {
        Route::get('/', 'App\Http\Controllers\EventoController@listarEventos');
        Route::post('/', 'App\Http\Controllers\EventoController@crearEvento');
        Route::get('/{evento_id}', 'App\Http\Controllers\EventoController@verEvento')->where('evento_id', '[0-9]+');
        Route::put('/{evento_id}', 'App\Http\Controllers\EventoController@editarEvento')->where('evento_id', '[0-9]+');
        Route::delete('/{evento_id}', 'App\Http\Controllers\EventoController@eliminarEvento')->where('evento_id', '[0-9]+');
    });

    Route::prefix('registro-propiedad/industrial')->group(function () {
        Route::get('/', 'App\Http\Controllers\RegistroPropiedadController@listarRegIndustriales');
        Route::post('/', 'App\Http\Controllers\RegistroPropiedadController@crearRegIndustrial');
        Route::get('/{registro_id}', 'App\Http\Controllers\RegistroPropiedadController@verRegIndustrial')->where('registro_id', '[0-9]+');
        Route::put('/{registro_id}', 'App\Http\Controllers\RegistroPropiedadController@editarRegIndustrial')->where('registro_id', '[0-9]+');
        Route::delete('/{registro_id}', 'App\Http\Controllers\RegistroPropiedadController@eliminarRegIndustrial')->where('registro_id', '[0-9]+');
    });

    Route::prefix('registro-propiedad/intelectual')->group(function () {
        Route::get('/', 'App\Http\Controllers\RegistroPropiedadController@listarRegIntelectuales');
        Route::post('/', 'App\Http\Controllers\RegistroPropiedadController@crearRegIntelectual');
        Route::get('/{registro_id}', 'App\Http\Controllers\RegistroPropiedadController@verRegIntelectual')->where('registro_id', '[0-9]+');
        Route::put('/{registro_id}', 'App\Http\Controllers\RegistroPropiedadController@editarRegIntelectual')->where('registro_id', '[0-9]+');
        Route::delete('/{registro_id}', 'App\Http\Controllers\RegistroPropiedadController@eliminarRegIntelectual')->where('registro_id', '[0-9]+');
    });

    Route::prefix('patente')->group(function () {
        Route::get('/', 'App\Http\Controllers\RegistroPropiedadController@listarPatente');
        Route::post('/', 'App\Http\Controllers\RegistroPropiedadController@crearPatente');
        Route::get('/{patente_id}', 'App\Http\Controllers\RegistroPropiedadController@verPatente')->where('patente_id', '[0-9]+');
        Route::put('/{patente_id}', 'App\Http\Controllers\RegistroPropiedadController@editarPatente')->where('patente_id', '[0-9]+');
        Route::delete('/{patente_id}', 'App\Http\Controllers\RegistroPropiedadController@eliminarPatente')->where('patente_id', '[0-9]+');
    });

    Route::get('tipos-licencias', 'App\Http\Controllers\ParametricaController@tiposLicencias');
    Route::get('instituciones', 'App\Http\Controllers\ParametricaController@instituciones');
});
