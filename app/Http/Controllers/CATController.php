<?php

namespace App\Http\Controllers;

use App\Models\CertificadoAptitudTecnica;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CATController extends Controller
{
    public function todos()
    {
        return response()->json(CertificadoAptitudTecnica::all());
    }

    public function crearCAT(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'denominacion_comercial' => 'required|string',
            'nro_certificado' => 'required|numeric',
            'aptitud' => 'required|string',
            'vencimiento' => 'required|date',
            'titular_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $cat = CertificadoAptitudTecnica::create([
            'denominacion_comercial' => $request['denominacion_comercial'],
            'nro_certificado' => $request['nro_certificado'],
            'aptitud' => $request['aptitud'],
            'vencimiento' => $request['vencimiento'],
            'titular_id' => $request['titular_id'],
        ]);

        DB::commit();

        return response()->json([
            'message' => 'Certificado de Aptitud Técnica creado exitosamente',
            'cat' => $cat
        ], 201);
    }

    public function editarCAT(int $cat_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'denominacion_comercial' => 'required|string',
            'nro_certificado' => 'required|numeric',
            'aptitud' => 'required|string',
            'vencimiento' => 'required|date',
            'titular_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $cat = CertificadoAptitudTecnica::find($cat_id);

        if (!$cat) {
            return response()->json([
                'message' => 'Certificado de Aptitud Técnica no encontrado'
            ], 404);
        }

        DB::beginTransaction();

        $cat->denominacion_comercial = $request['denominacion_comercial'];
        $cat->nro_certificado = $request['nro_certificado'];
        $cat->aptitud = $request['aptitud'];
        $cat->vencimiento = $request['vencimiento'];
        $cat->titular_id = $request['titular_id'];

        $cat->save();

        DB::commit();

        return response()->json([
            'message' => 'Certificado de Aptitud Técnica actualizado exitosamente',
            'cat' => $cat
        ]);
    }

    public function eliminarCAT(int $cat_id)
    {
        $cat = CertificadoAptitudTecnica::find($cat_id);

        if (!$cat) {
            return response()->json([
                'message' => 'Certificado de Aptitud Técnica no encontrado'
            ], 404);
        }

        $cat->delete();

        return response()->json([
            'message' => 'Certificado de Aptitud Técnica eliminado exitosamente'
        ]);
    }

    public function verCAT(int $cat_id)
    {
        return CertificadoAptitudTecnica::find($cat_id) ??
            response()->json([
                'message' => 'Certificado de Aptitud Técnica no encontrado'
            ]);
    }
}
