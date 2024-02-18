<?php

namespace App\Http\Controllers;

use App\Models\RegistroPropiedadIndustrial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Patente;
use App\Models\RegistroPropiedadIntelectual;
use Illuminate\Support\Facades\DB;

class RegistroPropiedadController extends Controller
{
    // Registro de Propiedad Industrial
    // TODO: Agregar relacion con patentes
    public function crearRegIndustrial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'disenios_y_modelos' => 'required|string',
            'titular_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $registro = RegistroPropiedadIndustrial::create([
            'nombre' => $request['nombre'],
            'tipo' => $request['tipo'],
            'disenios_y_modelos' => $request['disenios_y_modelos'],
            'titular_id' => $request['titular_id'],
        ]);

        DB::commit();

        $registro->load('titular');

        return response()->json([
            'message' => 'Registro de Propiedad Industrial creado exitosamente',
            'registro' => $registro
        ], 201);
    }

    public function editarRegIndustrial(int $registro_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'disenios_y_modelos' => 'required|string',
            'titular_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $registro = RegistroPropiedadIndustrial::find($registro_id);

        if (!$registro) {
            return response()->json([
                'message' => 'Registro de Propiedad Industrial no encontrado'
            ], 404);
        }

        DB::beginTransaction();

        $registro->nombre = $request['nombre'];
        $registro->tipo = $request['tipo'];
        $registro->disenios_y_modelos = $request['disenios_y_modelos'];
        $registro->titular_id = $request['titular_id'];

        $registro->save();

        DB::commit();

        $registro->load('titular');

        return response()->json([
            'message' => 'Registro de Propiedad Industrial actualizado exitosamente',
            'registro' => $registro
        ]);
    }

    public function eliminarRegIndustrial(int $registro_id)
    {
        $registro = RegistroPropiedadIndustrial::find($registro_id);

        if (!$registro) {
            return response()->json([
                'message' => "Registro de Propiedad Industrial no encontrado"
            ], 404);
        }

        $registro->delete();

        return response()->json([
            'message' => 'Registro de Propiedad Industrial eliminado correctamente'
        ]);
    }

    public function listarRegIndustriales()
    {
        return response()->json(
            RegistroPropiedadIndustrial::with('titular')->get()
        );
    }

    public function verRegIndustrial(int $registro_id)
    {
        return RegistroPropiedadIndustrial::with('titular')->find($registro_id) ??
            response()->json([
                'message' => 'Registro de Propiedad Industrial no encontrado'
            ], 404);
    }
    // FIN Registro de Propiedad Industrial

    // Registro de Propiedad Intelectual
    public function crearRegIntelectual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'titular_id' => 'required|numeric|min:1',
            'tipo_licencia_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $registro = RegistroPropiedadIntelectual::create([
            'nombre' => $request['nombre'],
            'titular_id' => $request['titular_id'],
            'tipo_licencia_id' => $request['tipo_licencia_id'],
        ]);

        DB::commit();

        $registro->load(['titular', 'tipo_licencia']);

        return response()->json([
            'message' => 'Registro de Propiedad Intelectual creado exitosamente',
            'registro' => $registro
        ], 201);
    }

    public function editarRegIntelectual(int $registro_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'titular_id' => 'required|numeric|min:1',
            'tipo_licencia_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $registro = RegistroPropiedadIntelectual::find($registro_id);

        if (!$registro) {
            return response()->json([
                'message' => 'Registro de Propiedad Intelectual no encontrado'
            ], 404);
        }

        DB::beginTransaction();

        $registro->nombre = $request['nombre'];
        $registro->titular_id = $request['titular_id'];
        $registro->tipo_licencia_id = $request['tipo_licencia_id'];

        $registro->save();

        DB::commit();

        $registro->load(['titular', 'tipo_licencia']);

        return response()->json([
            'message' => 'Registro de Propiedad Intelectual actualizado exitosamente',
            'registro' => $registro
        ]);
    }

    public function eliminarRegIntelectual(int $registro_id)
    {
        $registro = RegistroPropiedadIntelectual::find($registro_id);

        if (!$registro) {
            return response()->json([
                'message' => "Registro de Propiedad Intelectual no encontrado"
            ], 404);
        }

        $registro->delete();

        return response()->json([
            'message' => 'Registro de Propiedad Intelectual eliminado correctamente'
        ]);
    }

    public function listarRegIntelectuales()
    {
        return response()->json(
            RegistroPropiedadIntelectual::with(['titular', 'tipo_licencia'])->get()
        );
    }

    public function verRegIntelectual(int $registro_id)
    {
        return RegistroPropiedadIntelectual::with(['titular', 'tipo_licencia'])->find($registro_id) ??
            response()->json([
                'message' => 'Registro de Propiedad Intelectual no encontrado'
            ], 404);
    }
    // FIN Registro de Propiedad Intelectual

    // Patente
    public function crearPatente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha_presentacion' => 'required|date',
            'titulo' => 'required|string',
            'titulares' => 'required|array|min:1',
            'titulares.*' => 'numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        DB::beginTransaction();

        $patente = Patente::create([
            'fecha_presentacion' => $request['fecha_presentacion'],
            'titulo' => $request['titulo']
        ]);

        $patente->titulares()->attach($request['titulares']);

        DB::commit();

        $patente->load('titulares');

        return response()->json([
            'message' => 'Patente creada exitosamente',
            'registro' => $patente
        ], 201);
    }

    public function editarPatente(int $patente_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha_presentacion' => 'required|date',
            'titulo' => 'required|string',
            'titulares' => 'required|array|min:1',
            'titulares.*' => 'numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $patente = Patente::find($patente_id);

        if (!$patente) {
            return response()->json([
                'message' => 'Patente no encontrada'
            ], 404);
        }

        DB::beginTransaction();

        $patente->fecha_presentacion = $request['fecha_presentacion'];
        $patente->titulo = $request['titulo'];

        $patente->save();

        $patente->titulares()->sync($request['titulares']);

        DB::commit();

        $patente->load('titulares');

        return response()->json([
            'message' => 'Patente actualizada exitosamente',
            'registro' => $patente
        ]);
    }

    public function eliminarPatente(int $patente_id)
    {
        $patente = Patente::find($patente_id);

        if (!$patente) {
            return response()->json([
                'message' => "Patente no encontrada"
            ], 404);
        }

        $patente->delete();

        return response()->json([
            'message' => 'Patente eliminada correctamente'
        ]);
    }

    public function listarPatente()
    {
        return response()->json(
            Patente::all()
        );
    }

    public function verPatente(int $patente_id)
    {
        return Patente::with(['titulares'])->find($patente_id) ??
            response()->json([
                'message' => 'Patente no encontrada'
            ], 404);
    }
    // FIN Patente
}
