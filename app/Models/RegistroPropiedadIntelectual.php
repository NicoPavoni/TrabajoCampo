<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPropiedadIntelectual extends Model
{
    use HasFactory;

    protected $table = 'registro_propiedad_intelectual';
    public $fillable = [
        'nombre',
        'titular_id',
        'tipo_licencia_id',
    ];
    public $timestamps = false;

    public function tipo_licencia()
    {
        return $this->belongsTo(TipoLicencia::class);
    }

    public function titular()
    {
        return $this->belongsTo(Persona::class, 'titular_id');
    }
}
