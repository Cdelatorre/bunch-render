<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $table = 'notification_templates';

    /** Todos los campos son asignables; ajusta si quieres proteger alguno */
    protected $guarded = [];

    /**
     * Casts
     *  - shortcodes → objeto
     */
    protected $casts = [
        'shortcodes' => 'object',
    ];

    /**
     * Devolver array vacío si shortcodes es null
     */
    public function getShortcodesAttribute($value): array
    {
        if (is_null($value)) {
            return [];
        }
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return (array) $value;
    }
}
