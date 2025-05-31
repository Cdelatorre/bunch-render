<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtensionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('extensions')->updateOrInsert(
            ['act' => 'custom-captcha'],
            [
                'name'        => 'Custom Captcha',
                'version'     => '1.0',
                'description' => 'Internal captcha generator',
                'status'      => 0,
                // 👇  estructura típica
                'shortcode'   => json_encode([
                    'random_key' => [
                        'label' => 'Random Key',
                        'type'  => 'text',
                        'value' => 'CHANGE_ME_123456'   // pon aquí cualquier cadena
                    ]
                ]),
                'updated_at'  => now(),
                'created_at'  => now(),
            ]
        );
    }
}
