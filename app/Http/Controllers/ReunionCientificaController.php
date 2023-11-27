<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ReunionCientifica;
use App\Models\Expositor;
use App\Models\Persona;

class ReunionCientificaController extends Controller
{
    public function crearReunionNacional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'ciudad' => 'required|string',
            'expositor_id' => 'required|exists:expositores,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $reunion = ReunionCientifica::create([
            'nombre' => $request['nombre'],
            'fecha_inicio' => $request['fecha_inicio'],
            'ciudad' => $request['ciudad'],
            'nacional' => true,
            'expositor_id' => $request['expositor_id'],
        ]);

        DB::commit();

        return response()->json([
            'message' => 'Reunión nacional creada exitosamente',
            'reunion' => $reunion
        ], 201);
    }

    public function agregarAutor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reunion_id' => 'required|exists:reunion_cientifica,id',
            'autor_id' => 'required|exists:personas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes'
            ], 422);
        }

        $reunion = ReunionCientifica::find($request['reunion_id']);

        if (!$reunion) {
            return response()->json([
                'message' => 'Reunión no encontrada'
            ], 404);
        }

        DB::beginTransaction();

        $reunion->autores()->attach($request['autor_id']);

        DB::commit();

        return response()->json([
            'message' => 'Autor agregado a la reunión',
            'reunion' => $reunion
        ]);
    }

    public function buscarReunion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes'
            ], 422);
        }

        $reunion = ReunionCientifica::where('nombre', $request['nombre'])->first();

        if (!$reunion) {
            return response()->json([
                'message' => 'Reunión no encontrada'
            ], 404);
        }

        return response()->json(['reunion' => $reunion]);
    }

    public function crearReunionInternacional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'ciudad' => 'required|string',
            'expositor_id' => 'required|exists:expositores,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $reunion = ReunionCientifica::create([
            'nombre' => $request['nombre'],
            'fecha_inicio' => $request['fecha_inicio'],
            'ciudad' => $request['ciudad'],
            'nacional' => false,
            'expositor_id' => $request['expositor_id'],
        ]);

        DB::commit();

        return response()->json([
            'message' => 'Reunión internacional creada exitosamente',
            'reunion' => $reunion
        ], 201);
    }
}
