<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::find(2);
        $category = Category::find(2);

        if ($product && $category) {
            DB::table('category_products')->insert([
                'product_id' => $product->id,
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            echo "No se pudo insertar: producto o categoría no existen.\n";
        }
    }
}
