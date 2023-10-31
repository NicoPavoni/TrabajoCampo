<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
    protected $table = 'cuenta';
    public $fillable = [
        'numero_cuenta',
        'cbu',
        'client_id',
        'otp'
    ];
}
