<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enlace extends Model
{
    use HasFactory;

    protected $table = 'enlace';
    public $fillable = [
        'enlace',
        'documento_tecnico_id'
    ];
    public $timestamps = false;

    public function documentoTecnico()
    {
        return $this->belongsTo(DocumentoTecnico::class);
    }
}
