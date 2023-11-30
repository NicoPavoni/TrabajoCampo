<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'evento';
    public $fillable = [
        'lugar',
        'fecha',
        'nombre',
        'descripcion',
    ];
    public $timestamps = false;

    public function asistentes()
    {
        return $this->hasMany(Persona::class);
    }
}
