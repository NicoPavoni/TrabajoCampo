<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    // tipo_documento = 1: libro_capitulo
    // tipo_documento = 2: revista_nacional
    // tipo_documento = 3: articulo_con_referato
    // tipo_documento = 4: documento_tecnico

    protected $table = 'documento';
    public $fillable = [
        'nombre',
        'tipo_documento',
    ];
    public $timestamps = false;

    public function libroCapitulo()
    {
        return $this->hasOne(LibroCapitulo::class, 'documento_id');
    }

    public function revistaNacional()
    {
        return $this->hasOne(RevistaNacional::class, 'documento_id');
    }

    public function articuloConReferato()
    {
        return $this->hasOne(ArticuloConReferato::class, 'documento_id');
    }

    public function documentoTecnico()
    {
        return $this->hasOne(DocumentoTecnico::class, 'documento_id');
    }
}
