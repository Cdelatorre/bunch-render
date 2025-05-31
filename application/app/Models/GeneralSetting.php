<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    /** Tabla explícita – por si alguna vez cambias el nombre vía configuración */
    protected $table = 'general_settings';

    /** Todos los campos son asignables (ajusta si quieres proteger alguno) */
    protected $guarded = [];

    /**
     * Casts para que los JSON lleguen como objetos
     */
    protected $casts = [
        'mail_config'           => 'object',
        'sms_config'            => 'object',
        'socialite_credentials' => 'object',
        'global_shortcodes'     => 'object',
        'data_values'           => 'object',
    ];

    /**
     * Devuelve el nombre del sitio + título de página
     *
     * Uso:
     *   $title = GeneralSetting::first()->siteName('Dashboard');
     */
    public function scopeSiteName($query, $pageTitle)
    {
        $pageTitle = empty($pageTitle) ? '' : ' - ' . $pageTitle;
        /** @var self $setting */
        $setting   = $query->first();   // hay un único registro
        return $setting->site_name . $pageTitle;
    }

    /**
     * Acesso – siempre devolver array para los short-codes globales
     */
    public function getGlobalShortcodesAttribute($value): array
    {
        if (is_null($value)) {
            return [
                'site_name'       => 'Name of your site',
                'site_currency'   => 'Currency of your site',
                'currency_symbol' => 'Symbol of currency',
            ];
        }

        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        // Si $value ya es objeto/array
        return (array) $value;
    }

    /**
     * Vacía la caché cuando se actualiza el registro
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Cache::forget('GeneralSetting');
        });
    }
}
