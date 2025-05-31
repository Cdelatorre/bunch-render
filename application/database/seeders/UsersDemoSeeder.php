<?php
// database/seeders/UsersDemoSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersDemoSeeder extends Seeder
{
    /**
     * Inserta dos usuarios de prueba (IDs 2 y 3) con los
     * campos que realmente existen en tu tabla `users`
     * (`username`, `email`, `password`, `status`, timestamps).
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'id'         => 2223,
                'username'   => 'demo2asdafaewf',
                'email'      => 'demo2234q253@example.com',
                'password'   => Hash::make('secret'),  // ← cambia la contraseña si quieres
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 1231233,
                'username'   => 'demo31209401243',
                'email'      => 'demo3asdfasdg@example.com',
                'password'   => Hash::make('secret'),
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
