<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductUsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_users')->insert([
            [
                'id' => 1,
                'product_id' => 1,
                'user_id' => 2,
                'product_creator_id' => 1,
                'price' => 25.00,
                'visit_time' => Carbon::now()->addDay(),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
