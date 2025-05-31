<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLoginsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('user_logins')->insert([
            [
                'user_id'   => 1,
                'user_ip'   => '192.168.0.10',
                'browser'   => 'Chrome 125.0',
                'os'        => 'macOS 14.4',
                'created_at'=> $now->copy()->subDays(1),
                'updated_at'=> $now->copy()->subDays(1),
            ],
            [
                'user_id'   => 2,
                'user_ip'   => '203.0.113.55',
                'browser'   => 'Firefox 126.0',
                'os'        => 'Windows 11',
                'created_at'=> $now->copy()->subHours(6),
                'updated_at'=> $now->copy()->subHours(6),
            ],
            [
                'user_id'   => 3,
                'user_ip'   => '2a02:6b8::dead:beef',
                'browser'   => 'Safari 17.5',
                'os'        => 'iOS 17',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
        ]);
    }
}
