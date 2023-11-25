<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';
    public $fillable = [
        'nombre',
        'apellido',
        'dni',
        'cuil',
        'email',
        'telefono',
        'celular',
        'direccion_postal',
        'email_personal',
        'user_id',
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
