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

    public function tipo_documento_tecnico()
    {
        return $this->belongsTo(TipoDocumentoTecnico::class, 'tipo_documento_tecnico_id');
    }

    public function enlaces()
    {
        return $this->hasMany(Enlace::class, 'documento_tecnico_id');
    }
}
