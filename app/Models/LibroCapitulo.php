<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroCapitulo extends Model
{
    use HasFactory;

    protected $table = 'libro_capitulo';
    public $fillable = [
        'isbn',
        'editorial',
        'nro_capitulo',
        'documento_id'
    ];
    public $timestamps = false;

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}
