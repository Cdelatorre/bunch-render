<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $now      = now();
        $products = DB::table('products')->pluck('id');   // todos los gimnasios

        foreach ($products as $pid) {
            DB::table('product_images')->insert([
                'product_id' => $pid,
                'path'       => 'general',        // subcarpeta dentro de assets/images/product
                'image'      => 'default.png',    // el placeholder real (ya existe)
                'is_main'    => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
