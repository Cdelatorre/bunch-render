<?php
// app/Models/Services.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    /* ---------------------------------------------------------------
     | Mass-assignment
     |--------------------------------------------------------------- */
    protected $fillable = [
        'name',
        'description',
        'parent',   // ⬅️ añadido
        'status',   // ⬅️ añadido
    ];

    /* ---------------------------------------------------------------
     | Relaciones auto-referenciadas
     |--------------------------------------------------------------- */
    public function parentService()
    {
        return $this->belongsTo(self::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent');
    }

    /* ---------------------------------------------------------------
     | Accessor para la badge de estado
     |--------------------------------------------------------------- */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status
            ? '<span class="badge badge--success">'.trans('Active').'</span>'
            : '<span class="badge badge--danger">'.trans('Inactive').'</span>';
    }
}
