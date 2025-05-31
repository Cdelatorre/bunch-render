<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('general_settings')->updateOrInsert(
            ['id' => 1],
            [
                /* ───────── Básico ───────── */
                'site_name'         => 'Bunch of Clubs',
                'site_title'        => 'Bunch of Clubs',
                'email_from'        => 'no-reply@bunchofclubs.test',

                /* ───────── Moneda ───────── */
                'cur_text'          => 'EUR',
                'cur_sym'           => '€',
                'site_currency'     => 'EUR',

                /* ───────── Colores ───────── */
                'base_color'        => '008d9d',
                'secondary_color'   => '000000',

                /* ───────── Template & home ───────── */
                'active_template'   => 'default',
                'homesection'       => 1,

                /* ───────── Flags ───────── */
                'maintenance_mode'  => 0,
                'force_ssl'         => 0,
                'kv'                => 0,
                'ev'                => 0,
                'sv'                => 0,
                'tv'                => 0,
                'en'                => 1,
                'sn'                => 0,
                'secure_password'   => 0,
                'registration'      => 1,
                'agree'             => 0,

                /* ───────── Config. JSON ───────── */
                'mail_config' => json_encode(['name' => 'php']),
                'socialite_credentials' => json_encode([
                    'google'   => ['client_id' => '', 'client_secret' => '', 'redirect' => '', 'status' => 0],
                    'facebook' => ['client_id' => '', 'client_secret' => '', 'redirect' => '', 'status' => 0],
                    'linkedin' => ['client_id' => '', 'client_secret' => '', 'redirect' => '', 'status' => 0],
                ]),

                /* ───────── Short-codes globales ───────── */
                'global_shortcodes' => json_encode([
                    'site_name'       => 'Name of your site',
                    'site_currency'   => 'Currency of your site',
                    'currency_symbol' => 'Symbol of currency',
                ], JSON_UNESCAPED_UNICODE),

                /* ───────── Timestamps ───────── */
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
