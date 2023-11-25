<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentoTecnico extends Model
{
    use HasFactory;

    protected $table = 'tipo_documento_tecnico';
    public $fillable = [
        'nombre',
    ];
    public $timestamps = false;

    public function documentosTecnicos()
    {
        return $this->belongsTo(DocumentoTecnico::class);
    }
}
