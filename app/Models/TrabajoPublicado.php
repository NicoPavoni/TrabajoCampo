<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajoPublicado extends Model
{
    use HasFactory;

    protected $table = 'trabajo_publicado';
    public $fillable = [
        'titulo',
    ];
    public $timestamps = false;
}
