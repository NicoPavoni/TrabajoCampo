<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    protected $table = 'institucion';
    public $fillable = [
        'tipo',
        'nombre',
    ];
    public $timestamps = false;

    public function regPropIntelectuales()
    {
        return $this->belongsTo(RegistroPropiedadIntelectual::class);
    }
}
