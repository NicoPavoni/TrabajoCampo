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
        return $this->belongsTo(Expositor::class, 'expositor_id');
    }
}
