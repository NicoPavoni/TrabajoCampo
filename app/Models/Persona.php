<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';
    public $fillable = [
        'nombre',
        'apellido',
        'dni',
        'cuil',
        'email',
        'telefono',
        'celular',
        'direccion_postal',
        'email_personal',
        'user_id',
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a muchos con Reuniones Científicas
    public function reunionesCientificas()
    {
        return $this->belongsToMany(ReunionCientifica::class, 'autores_reunion', 'persona_id', 'reunion_cientifica_id');
    }

    public function patentes()
    {
        return $this->belongsToMany(Patente::class, 'patente_persona');
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'asistentes_evento', 'persona_id', 'evento_id');
    }
}
