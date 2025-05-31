<?php
// database/seeders/ProductsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $templates = [
            1 => 'Bunch of Clubs – Gym Alpha',
            2 => 'Bunch of Clubs – Gym Beta',
            3 => 'Bunch of Clubs – Gym Gamma',
        ];

        foreach ($templates as $id => $title) {
            DB::table('products')->insert([
                'id'                => $id,
                'user_id'           => 1,                // owner = gymowner
                'category_id'       => 1,
                'service_id'        => 1,
                'title'             => $title,
                'slug'              => Str::slug($title),
                'description'       => 'Sample gym just for dashboard counters.',
                'short_description' => 'Resumen de ejemplo.',
                'email'             => "test{$id}@test.com",
                'phone'             => '+34 600 000 000',
                'website'           => 'https://bunchofclubs.test',
                'social_link'       => 'https://instagram.com/bunchofclubs',
                'call_to_action'    => 'https://bunchofclubs.test/contact',
                'formatted_address' => 'C/ Ejemplo 123, Madrid',
                'address'           => json_encode([
                    'street_name'   => 'C/ Ejemplo',
                    'street_number' => '123',
                    'zip_code'      => '28000',
                    'locality'      => 'Madrid',
                    'province'      => 'Madrid',
                    'lat'           => 30.4167,
                    'lng'           => -2.7039,
                ]),
                'billing_address'   => json_encode([
                    'street_name'   => 'C/ Falsa',
                    'street_number' => '123',
                    'zip_code'      => '28000',
                    'locality'      => 'Madrid',
                    'province'      => 'Madrid',
                ]),
                'place_id'            => 'abc123',
                'latitude'            => 40.4167,
                'longitude'           => -3.7039,
                'google_rating'       => 4.5,
                'google_review_count' => 120,
                'started_at'          => $now,
                'expired_at'          => $now->copy()->addDays(30),
                'schedules'           => json_encode([
                    ['name' => 'Monday – Friday','start_time' => '08:00','end_time' => '20:00','status' => 'opened'],
                    ['name' => 'Saturday','start_time' => '09:00','end_time' => '14:00','status' => 'opened'],
                    ['name' => 'Sunday','start_time' => '09:00','end_time' => '14:00','status' => 'closed'],
                ]),
                'rates'              => json_encode([
                    ['title' => 'Básico','description' => 'Acceso general','price' => 10],
                    ['title' => 'Premium','description' => 'Acceso completo','price' => 25],
                ]),
                'price'        => 10,
                'bid_count'    => 0,   // se actualizará en BidsSeeder
                'avg_review'   => 4.7,
                'review_count' => 5,
                'status'       => 1,
                'gm'           => 0,
                'bid_complete' => 0,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
        }
    }
}
