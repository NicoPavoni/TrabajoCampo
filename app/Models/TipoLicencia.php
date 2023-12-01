<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLicencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_licencia';
    public $fillable = [
        'nombre',
    ];
    public $timestamps = false;

    public function regPropIntelectuales()
    {
        return $this->belongsTo(RegistroPropiedadIntelectual::class);
    }
}
