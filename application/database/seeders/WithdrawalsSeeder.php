<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawalsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('withdrawals')->insert([
            [
                'user_id'    => 1,
                'amount'     => 150,
                'status'     => 0,           // pendiente
                'meta'       => json_encode(['method' => 'Bank Transfer']),
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'user_id'    => 2,
                'amount'     => 75,
                'status'     => 2,           // rechazado
                'meta'       => json_encode(['method' => 'PayPal']),
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
        ]);
    }
}
