<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoTecnico extends Model
{
    use HasFactory;

    protected $table = 'documento_tecnico';
    public $fillable = [
        'lugar',
        'fecha',
        'documento_id',
        'tipo_documento_tecnico_id',
    ];
    public $timestamps = false;
}
