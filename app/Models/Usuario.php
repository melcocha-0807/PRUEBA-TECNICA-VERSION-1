<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    // App\Models\Usuario.php
    protected $fillable = [
    'identificacion',
    'nombres',
    'apellidos',
    'email',
    'telefono',
    'rol',
    'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];
}
