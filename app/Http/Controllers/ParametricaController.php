<?php

namespace App\Http\Controllers;

use App\Models\TipoLicencia;
use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\TipoDocumentoTecnico;

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

    public function personas()
    {
        return Persona::all();
    }

    public function tiposDocumentosTecnicos()
    {
        return TipoDocumentoTecnico::all();
    }
}
