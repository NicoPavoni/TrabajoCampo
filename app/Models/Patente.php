<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patente extends Model
{
    use HasFactory;

    protected $table = 'patente';
    public $fillable = [
        'fecha_presentacion',
        'titulo',
        'registro_propiedad_id',
    ];
    public $timestamps = false;

    public function regPropIndustriales()
    {
        return $this->belongsTo(RegistroPropiedadIndustrial::class, 'registro_propiedad_id');
    }

    public function titulares()
    {
        return $this->belongsToMany(Persona::class, 'patente_persona');
    }
}
