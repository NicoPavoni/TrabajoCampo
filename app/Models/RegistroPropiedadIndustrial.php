<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPropiedadIndustrial extends Model
{
    use HasFactory;

    protected $table = 'registro_propiedad_industrial';
    public $fillable = [
        'nombre',
        'tipo',
        'disenios_y_modelos',
        'titular_id',
    ];
    public $timestamps = false;

    public function titular()
    {
        return $this->belongsTo(Persona::class, 'titular_id');
    }

    public function patentes()
    {
        return $this->hasMany(Patente::class, 'registro_propiedad_id');
    }
}
