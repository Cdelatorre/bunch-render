<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontendsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('frontends')->insert([

            /* =========================================================
             |  HOME (hero) – se usa en home.blade (homeone.content)
             |=========================================================*/
            [
                'data_keys'   => 'homeone.content',
                'data_values' => json_encode([
                    'headline' => 'Find your perfect gym',
                    'subtext'  => 'Book sessions in seconds',
                    'button_text' => 'Explore now',
                    'button_link' => '/gyms',
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            /* =========================================================
             |  FOOTER genérico
             |=========================================================*/
            [
                'data_keys'   => 'footer.element',
                'data_values' => json_encode([
                    'text' => '© ' . date('Y') . ' Bunch of Clubs. All rights reserved.'
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            /* =========================================================
             |  ICONOS SOCIALES (pueden ir varios con la misma data_key)
             |=========================================================*/
            [
                'data_keys'   => 'social_icon.element',
                'data_values' => json_encode([
                    'url'         => 'https://twitter.com/bunchofclubs',
                    'social_icon' => '<i class="fab fa-twitter"></i>'
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'data_keys'   => 'social_icon.element',
                'data_values' => json_encode([
                    'url'         => 'https://facebook.com/bunchofclubs',
                    'social_icon' => '<i class="fab fa-facebook-f"></i>'
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            /* =========================================================
             |  BLOQUE CONTACTO (footer)
             |=========================================================*/
            [
                'data_keys'   => 'contact_us.content',
                'data_values' => json_encode([
                    'website_footer' => 'C/ Ejemplo 123, Madrid &nbsp;·&nbsp; +34 600 000 000'
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            /* =========================================================
             |  PÁGINAS DE POLÍTICA
             |=========================================================*/
            [
                'data_keys'   => 'policy_pages.element',
                'data_values' => json_encode([
                    'title' => 'Privacy&nbsp;Policy'
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            /* =========================================================
             |  COOKIES (GDPR)
             |=========================================================*/
            [
                'data_keys'   => 'cookie.data',
                'data_values' => json_encode([
                    'status'     => 1,
                    'short_desc' => 'Usamos cookies para mejorar la experiencia.',
                ]),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            /* =========================================================
             |  SOCIAL LOGIN – credenciales (arreglo con facebook/google…)
             |=========================================================*/
           // Google
            // Social login – credenciales
            [
              'data_keys'   => 'social_login.credential',
              'data_values' => json_encode([
                  'google' => [
                      'client_id'     => '',
                      'client_secret' => '',
                      'redirect'      => '',
                      'status'        => 0   // 1 para mostrar botón
                  ],
                  'facebook' => [
                      'client_id'     => '',
                      'client_secret' => '',
                      'redirect'      => '',
                      'status'        => 0
                  ],
                  'linkedin' => [
                      'client_id'     => '',
                      'client_secret' => '',
                      'redirect'      => '',
                      'status'        => 0
                  ],
              ]),
              'status'      => 1,
              'created_at'  => now(),
              'updated_at'  => now(),
            ],

        ]);
    }
}
