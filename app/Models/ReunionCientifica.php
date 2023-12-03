<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReunionCientifica extends Model
{
    use HasFactory;

    protected $table = 'reunion_cientifica';
    public $fillable = [
        'nombre',
        'fecha_inicio',
        'trabajo_id',
        'ciudad',
        'pais',
        'nacional',
        'expositor_id',
    ];
    public $timestamps = false;

    public function expositor()
    {
        return $this->belongsTo(Persona::class, 'expositor_id');
    }

    // Relación muchos a muchos con Personas (autores)
    public function autores()
    {
        return $this->belongsToMany(Persona::class, 'autores_reunion', 'reunion_cientifica_id', 'persona_id');
    }
}
