<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Documento;
use App\Models\DocumentoTecnico;
use App\Models\ArticuloConReferato;
use App\Models\RevistaNacional;
use App\Models\LibroCapitulo;

// Defino las constantes para cada tipo de documento asi queda mas legible en el codigo

if (!defined('LIBRO_CAPITULO')) {
    define('LIBRO_CAPITULO', 1);
}

if (!defined('REVISTA_NACIONAL')) {
    define('REVISTA_NACIONAL', 2);
}

if (!defined('ARTICULO_CON_REFERATO')) {
    define('ARTICULO_CON_REFERATO', 3);
}

if (!defined('DOCUMENTO_TECNICO')) {
    define('DOCUMENTO_TECNICO', 4);
}

class DocumentoController extends Controller
{
    public function crearLibroCapitulo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'editorial' => 'required|string',
            'isbn' => 'required|string',
            'nro_capitulo' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $documento = Documento::create([
            'nombre' => $request['nombre'],
            'tipo_documento' => LIBRO_CAPITULO
        ]);

        $libroCapitulo = LibroCapitulo::create([
            'isbn' => $request['isbn'],
            'editorial' => $request['editorial'],
            'nro_capitulo' => $request['nro_capitulo'] ?? null,
            'documento_id' => $documento->id,
        ]);

        DB::commit();

        $documento->libroCapitulo = $libroCapitulo;

        return response()->json([
            'message' => 'Libro/Capitulo creado exitosamente',
            'libro_capitulo' => $documento
        ], 201);
    }

    public function editarLibroCapitulo(int $documento_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'editorial' => 'required|string',
            'isbn' => 'required|string',
            'nro_capitulo' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $documento = Documento::with('libroCapitulo')->find($documento_id);

        if (!$documento) {
            return response()->json([
                'message' => 'Libro/capitulo no encontrado'
            ], 404);
        }

        if (!$documento->libroCapitulo) {
            return response()->json([
                'message' => 'Error de persistencia: Ese Libro/Capitulo no tiene un Documento relacionado'
            ], 500);
        }

        DB::beginTransaction();

        $documento->nombre = $request['nombre'];
        $documento->libroCapitulo->editorial = $request['editorial'];
        $documento->libroCapitulo->isbn = $request['isbn'];
        $documento->libroCapitulo->nro_capitulo = $request['nro_capitulo'] ?? null;

        $documento->push();

        DB::commit();

        return response()->json([
            'message' => 'Libro/Capitulo actualizado exitosamente',
            'libro_capitulo' => $documento
        ]);
    }

    public function eliminarDocumento(int $documento_id)
    {
        $documento = Documento::find($documento_id);

        if (!$documento) {
            return response()->json([
                'message' => 'Documento no encontrado'
            ], 404);
        }

        $documento->delete();

        return response()->json([
            'message' => 'Documento eliminado exitosamente'
        ]);
    }

    public function listarDocumentos(int $pagina = 1)
    {
        $documentos = Documento::offset(($pagina - 1) * 10)->limit(10)->get();

        foreach ($documentos as $documento) {
            switch ($documento->tipo_documento) {
                case LIBRO_CAPITULO:
                    $documento->load('libroCapitulo');
                    break;
                case REVISTA_NACIONAL:
                    $documento->load('revistaNacional');
                    break;
                case ARTICULO_CON_REFERATO:
                    $documento->load('articuloConReferato');
                    break;
                case DOCUMENTO_TECNICO:
                    $documento->load('documentoTecnico');
                    break;
            }
        }

        return response()->json($documentos);
    }
}
