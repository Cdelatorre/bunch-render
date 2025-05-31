<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    /* ---------------------------------------------------------------
     | Mass-assignment
     |--------------------------------------------------------------- */
    protected $fillable = [
        'username',
        'name',              // ⬅️ añadido
        'email',
        'password',
        'image',             // ⬅️ añadido
        'is_super',
    ];

    /* ---------------------------------------------------------------
     | Hidden / Casts
     |--------------------------------------------------------------- */
    protected $hidden = ['password', 'remember_token'];

    protected $casts  = [
        'is_super' => 'boolean',
    ];
}
