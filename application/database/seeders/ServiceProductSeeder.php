<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceProduct;
use App\Models\Product;
use App\Models\Services;

class ServiceProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $services = Services::all();

        if ($products->isEmpty() || $services->isEmpty()) {
            $this->command->warn('No hay productos o servicios para asociar.');
            return;
        }

        foreach ($products as $product) {
            // Asocia entre 1 y 3 servicios aleatorios a cada producto
            $randomServices = $services->random(rand(1, min(3, $services->count())));

            foreach ($randomServices as $service) {
                ServiceProduct::create([
                    'product_id' => $product->id,
                    'service_id' => $service->id,
                ]);
            }
        }

        $this->command->info('Se han asociado servicios a los productos correctamente.');
    }
}
