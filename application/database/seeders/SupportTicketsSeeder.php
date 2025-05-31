<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportTicketsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('support_tickets')->insert([
            [
                'user_id'    => 1,
                'subject'    => 'Demo ticket abierto',
                'message'    => 'Sólo un ejemplo para el dashboard.',
                'status'     => 0,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'user_id'    => 2,
                'subject'    => 'Segundo ticket contestado',
                'message'    => 'Respuesta en proceso.',
                'status'     => 2,
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
        ]);
    }
}
