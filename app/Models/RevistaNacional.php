<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevistaNacional extends Model
{
    use HasFactory;

    protected $table = 'revista_nacional';
    public $fillable = [
        'pais',
        'editorial',
        'issn',
        'trabajo_id',
        'con_referato',
        'documento_id',
    ];
    public $timestamps = false;

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function trabajo_publicado()
    {
        return $this->belongsTo(TrabajoPublicado::class, 'trabajo_id');
    }
}
