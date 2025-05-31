<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissingProductImagesSeeder extends Seeder
{
  public function run(): void
    {
        $now = now();

        $missing = DB::table('products')
                    ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
                    ->whereNull('product_images.id')
                    ->pluck('products.id');

        foreach ($missing as $pid) {
            DB::table('product_images')->insert([
                'product_id' => $pid,
                'path'       => 'general',          // ↳  public/assets/images/product/general/
                'image'      => 'default.png',      // ↳  placeholder real
                'is_main'    => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

}
