<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;

class CuentaController extends Controller
{
    public function validarTransferenciaDeFondos(float $monto, string $cuentaEnvioID, string $cuentaDestinoID, string $token)
    {
        $cuenta = Cuenta::where('numero_cuenta', $cuentaEnvioID);

        if (!$cuenta) {
            return response()->json([
                'message' => 'Cuenta inexistente'
            ], 404);
        }
    }
}
