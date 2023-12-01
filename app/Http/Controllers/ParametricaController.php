<?php

namespace App\Http\Controllers;

use App\Models\TipoLicencia;
use App\Models\Institucion;
use Illuminate\Http\Request;

class ParametricaController extends Controller
{
    public function tiposLicencias()
    {
        return TipoLicencia::all();
    }

    public function instituciones()
    {
        return Institucion::all();
    }
}
