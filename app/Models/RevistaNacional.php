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
        'titulo_trabajo',
        'con_referato',
        'documento_id',
    ];
    public $timestamps = false;

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}
