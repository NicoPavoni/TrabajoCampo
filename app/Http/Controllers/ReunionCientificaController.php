<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ReunionCientifica;
use App\Models\Persona;

class ReunionCientificaController extends Controller
{
    public function crearReunionCientifica(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'trabajo_id' => 'required|numeric|min:1',
            'ciudad' => 'required_if_accepted:nacional',
            'pais' => 'required_unless:nacional,1',
            'nacional' => 'required|boolean',
            'expositor_id' => 'required|numeric|min:1',
            'autores' => 'nullable|array',
            'autores.*' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        $reunion = ReunionCientifica::create([
            'nombre' => $request['nombre'],
            'fecha_inicio' => $request['fecha_inicio'],
            'trabajo_id' => $request['trabajo_id'],
            'ciudad' => $request['nacional'] == 1 ? $request['ciudad'] : null,
            'pais' => $request['nacional'] == 0 ? $request['pais'] : null,
            'nacional' => $request['nacional'],
            'expositor_id' => $request['expositor_id'],
        ]);

        $reunion->autores()->attach($request['autores']);

        DB::commit();

        $reunion->load(['autores', 'expositor', 'trabajo_publicado']);

        return response()->json([
            'message' => 'Reunión Cientifica creada exitosamente',
            'reunion' => $reunion,
        ], 201);
    }

    public function editarReunionCientifica(int $reunion_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'trabajo_id' => 'required|numeric|min:1',
            'ciudad' => 'required_if_accepted:nacional',
            'pais' => 'required_unless:nacional,1',
            'nacional' => 'required|boolean',
            'expositor_id' => 'required|numeric|min:1',
            'autores' => 'nullable|array',
            'autores.*' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes',
            ], 422);
        }

        $reunion = ReunionCientifica::find($reunion_id);

        if (!$reunion) {
            return response()->json([
                'message' => 'Reunión Cientifica no encontrada',
            ], 404);
        }

        DB::beginTransaction();

        $reunion->nombre = $request['nombre'];
        $reunion->fecha_inicio = $request['fecha_inicio'];
        $reunion->trabajo_id = $request['trabajo_id'];
        $reunion->ciudad = $request['nacional'] == 1 ? $request['ciudad'] : null;
        $reunion->pais = $request['nacional'] == 0 ? $request['pais'] : null;
        $reunion->nacional = $request['nacional'];
        $reunion->expositor_id = $request['expositor_id'];

        $reunion->save();

        $reunion->autores()->sync($request['autores']);

        DB::commit();

        // Cargar la relación después de la transacción
        $reunion->load(['autores', 'expositor', 'trabajo_publicado']);

        return response()->json([
            'message' => 'Reunión Cientifica actualizada exitosamente',
            'reunion' => $reunion,
        ]);
    }

    public function listarReunionesCientificas()
    {
        return response()->json(ReunionCientifica::with(['expositor', 'trabajo_publicado'])->get());
    }

    public function eliminarReunionCientifica(int $reunion_id)
    {
        $reunion = ReunionCientifica::find($reunion_id);

        if (!$reunion) {
            return response()->json([
                'message' => 'Reunion Cientifica no encontrada'
            ], 404);
        }

        $reunion->delete();

        return response()->json([
            'message' => 'Reunion Cientifica eliminada correctamente'
        ]);
    }

    public function verReunion(int $reunion_id)
    {
        return ReunionCientifica::with(['autores', 'expositor', 'trabajo_publicado'])->find($reunion_id) ??
            response()->json([
                'message' => 'Reunion Cientifica inexistente'
            ], 404);
    }
}
