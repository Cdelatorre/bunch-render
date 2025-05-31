<?php
// database/seeders/SearchHistoriesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SearchHistoriesSeeder extends Seeder
{
    /**
     * Crea los usuarios de demo (id 2 y 3) si aún no existen.
     */
    protected function ensureDemoUsers(): void
    {
        foreach ([2, 3] as $id) {
            if (!DB::table('users')->where('id', $id)->exists()) {
                DB::table('users')->insert([
                    'id'         => $id,
                    'username'   => "demo{$id}",
                    'email'      => "demo{$id}@example.com",
                    'password'   => Hash::make('secret'),
                    'status'     => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function run(): void
    {
        // 1- Aseguramos usuarios de demo
        $this->ensureDemoUsers();

        // 2- Desactivamos los chequeos FK por si acaso
        Schema::disableForeignKeyConstraints();

        $now = Carbon::now();

        DB::table('search_histories')->insert([
            [
                'user_id'      => 2,
                'keyword'      => 'gym madrid',
                'activities'   => json_encode([1]),        // <-- string JSON
                'services'     => json_encode([1, 2]),     // "
                'search_count' => 5,
                'city'         => 'Madrid',
                'min_price'    => 25.00,
                'max_price'    => 50.00,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 3,
                'keyword'      => 'pilates barcelona',
                'activities'   => json_encode([3]),
                'services'     => json_encode([4]),
                'search_count' => 3,
                'city'         => 'Barcelona',
                'min_price'    => 40.00,
                'max_price'    => 75.00,
                'created_at'   => $now->copy()->subDay(),
                'updated_at'   => $now->copy()->subDay(),
            ],
        ]);

        // 3- Volvemos a activar los chequeos FK
        Schema::enableForeignKeyConstraints();
    }
}
