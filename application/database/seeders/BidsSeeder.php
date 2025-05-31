<?php
// database/seeders/BidsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        /* -----------------------------------------------------------------
         | product_id | user_id | price | visit_time | product_creator_id
         *-----------------------------------------------------------------*/
        $bids = [
            [1, 2,  0.00, $now->copy()->subDays(7), 1],
            [1, 3,  0.00, $now->copy()->subDays(2), 1],
            [1, 3,  0.00, $now->copy()->subDay(),   1],
            [2, 3, 15.00, $now->copy()->subHours(3),1],
            [1, 2, 20.00, $now,                     1],
        ];

        foreach ($bids as $row) {
            DB::table('product_users')->insert([
                'product_id'        => $row[0],
                'user_id'           => $row[1],
                'product_creator_id'=> $row[4],
                'price'             => $row[2],
                'visit_time'        => $row[3],
                'status'            => 1,          // aprobado
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);
        }

        /* --- actualiza bid_count en products --- */
        $counts = DB::table('product_users')
                    ->selectRaw('product_id, COUNT(*) as c')
                    ->groupBy('product_id')
                    ->pluck('c', 'product_id')
                    ->toArray();

        foreach ($counts as $productId => $c) {
            DB::table('products')
              ->where('id', $productId)
              ->update(['bid_count' => $c]);
        }
    }
}
