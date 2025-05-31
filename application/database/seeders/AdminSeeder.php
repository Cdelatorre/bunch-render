<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        /*  ─────────────────────────────────────────────────────────────
         |  Si existe un admin con username = admin se actualiza,
         |  si no, se crea.  Solo se usan columnas reales de la tabla.
         ───────────────────────────────────────────────────────────── */
        DB::table('admins')->updateOrInsert(
            ['username' => 'admin'],            // clave de búsqueda
            [
                'username'   => 'admin',
                'name'       => 'Super Admin',  // ⬅️ añadido
                'email'      => 'admin@demo.local',
                'password'   => Hash::make('Admin@123'),
                'is_super'   => true,
                'image'      => null,           // ⬅️ añadido (opcional)
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
