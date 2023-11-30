<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Evento;
use App\Models\Persona;

class EventoController extends Controller
{
    public function crearEvento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'asistentes' => 'nullable|array',
            'asistentes.*' => 'numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $evento = Evento::create([
            'lugar' => $request['lugar'],
            'fecha' => $request['fecha'],
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
        ]);

        $evento->asistentes()->attach($request['autores']);

        DB::commit();

        // Cargar la relación después de la transacción
        $evento->load('asistentes');

        return response()->json([
            'message' => 'Evento creado exitosamente',
            'evento' => $evento
        ], 201);
    }

    public function editarEvento(int $evento_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'asistentes' => 'nullable|array',
            'asistentes.*' => 'numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parámetros inválidos y/o faltantes',
            ], 422);
        }

        $evento = Evento::find($evento_id);

        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
            ], 404);
        }

        DB::beginTransaction();

        $evento->lugar = $request['lugar'];
        $evento->fecha = $request['fecha'];
        $evento->nombre = $request['nombre'];
        $evento->descripcion = $request['descripcion'];
        $evento->save();

        $evento->asistentes()->sync($request['asistentes']);

        DB::commit();

        // Cargar la relación después de la transacción
        $evento->load('asistentes');

        return response()->json([
            'message' => 'Evento actualizado exitosamente',
            'evento' => $evento,
        ]);
    }

    public function buscarEvento(int $evento_id)
    {
        $evento = Evento::with('autores')->find($evento_id);

        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado'
            ], 404);
        }

        return response()->json(['evento' => $evento]);
    }
}
