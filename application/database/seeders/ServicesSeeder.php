<?php
// database/seeders/ServicesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        /* -----------------------------------------------------------------
         |  Estructura jerárquica
         |------------------------------------------------------------------
         |  id  parent   name
         |   1     0     Instalaciones generales
         |   2     0     Instalaciones de agua
         |   3     0     Áreas de bienestar y relajación
         |   4     0     Servicios de higiene y comodidad
         |   5     0     Servicios adicionales
         |   6-11         ← hijos de 1
         |  12-15         ← hijos de 2
         |  16-20         ← hijos de 3
         |  21-24         ← hijos de 4
         |  25-29         ← hijos de 5
         *-----------------------------------------------------------------*/

        $now = now();

        $services = [
            /* ---------- raíces ---------- */
            ['id' => 1, 'parent' => 0, 'name' => 'Instalaciones generales',             'description' => null, 'status' => 1],
            ['id' => 2, 'parent' => 0, 'name' => 'Instalaciones de agua',               'description' => null, 'status' => 1],
            ['id' => 3, 'parent' => 0, 'name' => 'Áreas de bienestar y relajación',     'description' => null, 'status' => 1],
            ['id' => 4, 'parent' => 0, 'name' => 'Servicios de higiene y comodidad',    'description' => null, 'status' => 1],
            ['id' => 5, 'parent' => 0, 'name' => 'Servicios adicionales',              'description' => null, 'status' => 1],

            /* ----- hijos de «Instalaciones generales» (parent = 1) ----- */
            ['id' => 6,  'parent' => 1, 'name' => 'Sala de pesas y máquinas',       'description' => null, 'status' => 1],
            ['id' => 7,  'parent' => 1, 'name' => 'Área de cardio',                 'description' => null, 'status' => 1],
            ['id' => 8,  'parent' => 1, 'name' => 'Zona de entrenamiento funcional','description' => null, 'status' => 1],
            ['id' => 9,  'parent' => 1, 'name' => 'Sala de clases grupales',        'description' => null, 'status' => 1],
            ['id' => 10, 'parent' => 1, 'name' => 'Zona de estiramientos',          'description' => null, 'status' => 1],
            ['id' => 11, 'parent' => 1, 'name' => 'Área de boxeo',                  'description' => null, 'status' => 1],

            /* ----- hijos de «Instalaciones de agua» (parent = 2) ----- */
            ['id' => 12, 'parent' => 2, 'name' => 'Piscina climatizada',    'description' => null, 'status' => 1],
            ['id' => 13, 'parent' => 2, 'name' => 'Zona de hidroterapia',   'description' => null, 'status' => 1],
            ['id' => 14, 'parent' => 2, 'name' => 'Ice bath',               'description' => null, 'status' => 1],
            ['id' => 15, 'parent' => 2, 'name' => 'Jacuzzi',                'description' => null, 'status' => 1],

            /* ----- hijos de «Áreas de bienestar y relajación» (3) ----- */
            ['id' => 16, 'parent' => 3, 'name' => 'Sauna',                         'description' => null, 'status' => 1],
            ['id' => 17, 'parent' => 3, 'name' => 'Baño turco',                    'description' => null, 'status' => 1],
            ['id' => 18, 'parent' => 3, 'name' => 'Sala de masajes',               'description' => null, 'status' => 1],
            ['id' => 19, 'parent' => 3, 'name' => 'Spa y área de tratamientos',    'description' => null, 'status' => 1],
            ['id' => 20, 'parent' => 3, 'name' => 'Solarium',                      'description' => null, 'status' => 1],

            /* ----- hijos de «Servicios de higiene y comodidad» (4) ----- */
            ['id' => 21, 'parent' => 4, 'name' => 'Duchas',                         'description' => null, 'status' => 1],
            ['id' => 22, 'parent' => 4, 'name' => 'Vestidores con taquillas',       'description' => null, 'status' => 1],
            ['id' => 23, 'parent' => 4, 'name' => 'Toallas disponibles',            'description' => null, 'status' => 1],
            ['id' => 24, 'parent' => 4, 'name' => 'Secadores y artículos de aseo',  'description' => null, 'status' => 1],

            /* ----- hijos de «Servicios adicionales» (5) ----- */
            ['id' => 25, 'parent' => 5, 'name' => 'Parking',                           'description' => null, 'status' => 1],
            ['id' => 26, 'parent' => 5, 'name' => 'Cafetería',                         'description' => null, 'status' => 1],
            ['id' => 27, 'parent' => 5, 'name' => 'Zona de trabajo o coworking',       'description' => null, 'status' => 1],
            ['id' => 28, 'parent' => 5, 'name' => 'Wifi gratuito',                    'description' => null, 'status' => 1],
            ['id' => 29, 'parent' => 5, 'name' => 'Tienda de productos deportivos',   'description' => null, 'status' => 1],
        ];

        // Añadimos timestamps
        $services = array_map(fn ($row) => $row + ['created_at' => $now, 'updated_at' => $now], $services);

        DB::table('services')->insert($services);
    }
}
