<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminNotificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin_notifications')->insert([
            [
                'user_id'     => 1,
                'title'       => 'Nuevo usuario registrado',
                'message'     => 'John Doe se ha unido a la plataforma.',
                'click_url'   => '/admin/users/detail/1',
                'read_status' => false,
                'created_at'  => now()->subMinutes(30),
                'updated_at'  => now()->subMinutes(30),
            ],
            [
                'user_id'     => null,
                'title'       => 'Backup completado',
                'message'     => 'Se ha generado el backup diario.',
                'click_url'   => '#',
                'read_status' => true,
                'created_at'  => now()->subHours(2),
                'updated_at'  => now()->subHours(2),
            ],
        ]);
    }
}
