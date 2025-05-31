<?php
// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();          // marca de tiempo común

        /*
         |---------------------------------------------------------------
         |  Cada elemento del array $posts será el contenido de data_values
         |---------------------------------------------------------------
         |  – title        → título del post
         |  – description  → texto (HTML o plain-text)
         |  – blog_image   → nombre del archivo (sin «thumb_», la miniatura
         |                    se genera o se llama igual con el prefijo)
         */
        $posts = [
            [
                'title'       => 'Bunchofclubs, la nueva forma de encontrar tu gimnasio ideal',
                'description' => 'Descubre cómo nuestra plataforma te ayuda a comparar gimnasios, servicios y precios para que elijas el centro que mejor se adapta a tu estilo de vida.',
                'blog_image'  => 'default.png',
            ],
            [
                'title'       => 'Entrenamientos funcionales: qué son, beneficios y dónde practicarlos',
                'description' => 'El entrenamiento funcional ha ganado popularidad por su capacidad de mejorar la fuerza y la movilidad para la vida diaria. Te contamos en qué consiste y cómo empezar.',
                'blog_image'  => 'default.png',
            ],
            [
                'title'       => '5 tendencias fitness que dominarán 2025',
                'description' => 'Desde el entrenamiento híbrido hasta la realidad virtual, repasamos las tendencias que marcarán el mundo del fitness en los próximos años.',
                'blog_image'  => 'default.png',
            ],
        ];

        foreach ($posts as $post) {
            DB::table('frontends')->insert([
                'data_keys'   => 'blog.element',           // clave que tu Blade espera
                'data_values' => json_encode($post),       // se guarda como JSON
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
