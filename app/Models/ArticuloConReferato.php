<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloConReferato extends Model
{
    use HasFactory;

    protected $table = 'articulo_con_referato';
    public $fillable = [
        'lugar',
        'fecha',
        'es_nacional',
        'documento_id'
    ];
    public $timestamps = false;

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}
