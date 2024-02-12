<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Documento;
use App\Models\DocumentoTecnico;
use App\Models\ArticuloConReferato;
use App\Models\Enlace;
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
    // Libro/Capitulo
    public function crearLibroCapitulo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'editorial' => 'required|string',
            'isbn' => 'required|string',
            'nro_capitulo' => 'nullable|string|min:0'
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
                'message' => 'Error de ruta: Ese Documento no tiene un Capitulo/Libro relacionado'
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
    // FIN Libro/Capitulo

    // Revista Nacional
    public function crearRevistaNacional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'pais' => 'required|string',
            'editorial' => 'required|string',
            'issn' => 'required|string',
            'titulo_trabajo' => 'required|string',
            'con_referato' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $documento = Documento::create([
            'nombre' => $request['nombre'],
            'tipo_documento' => REVISTA_NACIONAL
        ]);

        $revistaNacional = RevistaNacional::create([
            'pais' => $request['pais'],
            'editorial' => $request['editorial'],
            'issn' => $request['issn'],
            'titulo_trabajo' => $request['titulo_trabajo'],
            'con_referato' => $request['con_referato'],
            'documento_id' => $documento->id,
        ]);

        DB::commit();

        $documento->revistaNacional = $revistaNacional;

        return response()->json([
            'message' => 'Revista Nacional creada exitosamente',
            'revista_nacional' => $documento
        ], 201);
    }

    public function editarRevistaNacional(int $documento_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'pais' => 'required|string',
            'editorial' => 'required|string',
            'issn' => 'required|string',
            'titulo_trabajo' => 'required|string',
            'con_referato' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $documento = Documento::with('revistaNacional')->find($documento_id);

        if (!$documento) {
            return response()->json([
                'message' => 'Revista Nacional no encontrada'
            ], 404);
        }

        if (!$documento->revistaNacional) {
            return response()->json([
                'message' => 'Error de ruta: Ese Documento no tiene una Revista Nacional relacionada'
            ], 400);
        }

        DB::beginTransaction();

        $documento->nombre = $request['nombre'];
        $documento->revistaNacional->pais = $request['pais'];
        $documento->revistaNacional->editorial = $request['editorial'];
        $documento->revistaNacional->issn = $request['issn'];
        $documento->revistaNacional->titulo_trabajo = $request['titulo_trabajo'];
        $documento->revistaNacional->con_referato = $request['con_referato'];

        $documento->push();

        DB::commit();

        return response()->json([
            'message' => 'Revista Nacional actualizada exitosamente',
            'revista_nacional' => $documento
        ]);
    }
    // FIN Revista Nacional

    // Articulo con Referato
    public function crearArticuloConReferato(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'es_nacional' => 'required|boolean',
            'autores' => 'array|required',
            'autores.*' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $documento = Documento::create([
            'nombre' => $request['nombre'],
            'tipo_documento' => ARTICULO_CON_REFERATO
        ]);

        $articuloConReferato = ArticuloConReferato::create([
            'lugar' => $request['lugar'],
            'fecha' => $request['fecha'],
            'es_nacional' => $request['es_nacional'],
            'documento_id' => $documento->id,
        ]);

        $documento->autores()->attach($request['autores']);

        DB::commit();

        $documento->articuloConReferato = $articuloConReferato;
        $documento->load('autores');

        return response()->json([
            'message' => 'Articulo con Referato creado exitosamente',
            'articulo_con_referato' => $documento
        ], 201);
    }

    public function editarArticuloConReferato(int $documento_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'es_nacional' => 'required|boolean',
            'autores' => 'array|required',
            'autores.*' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $documento = Documento::with('articuloConReferato')->find($documento_id);

        if (!$documento) {
            return response()->json([
                'message' => 'Articulo con Referato no encontrado'
            ], 404);
        }

        if (!$documento->articuloConReferato) {
            return response()->json([
                'message' => 'Error de ruta: Ese Documento no tiene un Articulo con Referato relacionado'
            ], 400);
        }

        DB::beginTransaction();

        $documento->nombre = $request['nombre'];
        $documento->articuloConReferato->lugar = $request['lugar'];
        $documento->articuloConReferato->fecha = $request['fecha'];
        $documento->articuloConReferato->es_nacional = $request['es_nacional'] ?? null;

        $documento->push();

        $documento->autores()->sync($request['autores']);

        DB::commit();

        return response()->json([
            'message' => 'Articulo con Referato actualizado exitosamente',
            'articulo_con_referato' => $documento
        ]);
    }
    // FIN Articulo con Referato

    // Documento Tecnico
    public function crearDocumentoTecnico(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'tipo_documento_tecnico_id' => 'required|numeric|min:1',
            'enlaces' => 'nullable|array',
            'enlaces.*' => 'string',
            'autores' => 'array|required',
            'autores.*' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $documento = Documento::create([
            'nombre' => $request['nombre'],
            'tipo_documento' => DOCUMENTO_TECNICO
        ]);

        $documentoTecnico = DocumentoTecnico::create([
            'lugar' => $request['lugar'],
            'fecha' => $request['fecha'],
            'documento_id' => $documento->id,
            'tipo_documento_tecnico_id' => $request['tipo_documento_tecnico_id'],
        ]);

        if (isset($request['enlaces'])) {
            foreach ($request['enlaces'] as $enlace) {
                Enlace::create([
                    'enlace' => $enlace,
                    'documento_tecnico_id' => $documentoTecnico->id,
                ]);
            }
        }

        $documento->autores()->attach($request['autores']);

        DB::commit();

        $documentoTecnico->load('enlaces');
        $documento->documentoTecnico = $documentoTecnico;

        return response()->json([
            'message' => 'Documento Tecnico creado exitosamente',
            'documento_tecnico' => $documento
        ], 201);
    }

    public function editarDocumentoTecnico(int $documento_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'tipo_documento_tecnico_id' => 'required|numeric|min:1',
            'enlaces' => 'nullable|array',
            'enlaces.*' => 'string',
            'autores' => 'array|required',
            'autores.*' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $documento = Documento::with('documentoTecnico')->find($documento_id);

        if (!$documento) {
            return response()->json([
                'message' => 'Documento Tecnico no encontrado'
            ], 404);
        }

        if (!$documento->documentoTecnico) {
            return response()->json([
                'message' => 'Error de ruta: Ese Documento no tiene un Documento Tecnico relacionado'
            ], 400);
        }

        DB::beginTransaction();

        $documento->nombre = $request['nombre'];
        $documento->documentoTecnico->lugar = $request['lugar'];
        $documento->documentoTecnico->fecha = $request['fecha'];
        $documento->documentoTecnico->tipo_documento_tecnico_id = $request['tipo_documento_tecnico_id'];
        $documento->documentoTecnico->documento_id = $documento->id;

        $documento->push();

        // Se borran todas las relaciones que tienen con los enlaces en la base y se cargan los nuevos
        // (se supone que si estas editando un documento se vuelven a mandar los enlaces que ya tenia antes)
        $enlaces = Enlace::where('documento_tecnico_id', $documento->documentoTecnico->id)->get();

        foreach ($enlaces as $enlace) {
            $enlace->delete();
        }

        if (isset($request['enlaces'])) {
            foreach ($request['enlaces'] as $enlace) {
                Enlace::create([
                    'enlace' => $enlace,
                    'documento_tecnico_id' => $documento->documentoTecnico->id
                ]);
            }
        }

        $documento->autores()->sync($request['autores']);

        DB::commit();

        return response()->json([
            'message' => 'Documento Tecnico actualizado exitosamente',
            'documentoTecnico' => $documento
        ]);
    }
    // FIN Documento Tecnico

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

    /**
     * Metodo privado que dependiendo del numero de tipo_documento carga distintas relaciones de Documento con
     * sus tabla real
     */
    private function cargarRelacionDocumento(Documento $documento)
    {
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
                $documento->load(['documentoTecnico.tipo_documento_tecnico', 'documentoTecnico.enlaces']);
                break;
        }
    }

    public function listarDocumentos(int $tipo_documento)
    {
        $documentos = Documento::where('tipo_documento', $tipo_documento)->get();

        foreach ($documentos as $documento) {
            $this->cargarRelacionDocumento($documento);
        }

        return response()->json($documentos);
    }

    public function verDocumento(int $documento_id)
    {
        $documento = Documento::find($documento_id);

        if (!$documento) {
            return response()->json([
                'message' => 'Documento inexistente'
            ], 404);
        }

        $this->cargarRelacionDocumento($documento);
        $documento->load('autores');

        return response()->json($documento);
    }
}
