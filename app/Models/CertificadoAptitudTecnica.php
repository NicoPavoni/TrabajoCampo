<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificadoAptitudTecnica extends Model
{
    use HasFactory;

    protected $table = 'certificado_aptitud_tecnica';
    public $fillable = [
        'denominacion_comercial',
        'nro_certificado',
        'aptitud',
        'vencimiento',
        'titular_id',
    ];
    public $timestamps = false;

    public function titular()
    {
        return $this->belongsTo(Persona::class, 'titular_id');
    }
}
