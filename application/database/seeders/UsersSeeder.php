<?php
/**
 * Crea 3 usuarios de ejemplo (1 gym + 2 usuarios)
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            [
                'id'            => 1,
                'firstname'     => 'Gym',
                'lastname'      => 'Owner',
                'username'      => 'gymowner',
                'email'         => 'gym@example.com',
                'mobile'        => '600000001',
                'country_code'  => 'ES',
                'password'      => Hash::make('password'),
                'gm'            => 1,
                'balance'       => 0,
            ],
            [
                'id'            => 2,
                'firstname'     => 'John',
                'lastname'      => 'Doe',
                'username'      => 'johndoe',
                'email'         => 'john@example.com',
                'mobile'        => '600000002',
                'country_code'  => 'ES',
                'password'      => Hash::make('password'),
                'gm'            => 0,
                'balance'       => 100,
            ],
            [
                'id'            => 3,
                'firstname'     => 'Test',
                'lastname'      => 'User',
                'username'      => 'testuser',
                'email'         => 'testuser@example.com',
                'mobile'        => '600000003',
                'country_code'  => 'ES',
                'password'      => Hash::make('password'),
                'gm'            => 0,
                'balance'       => 50,
            ],
        ];

        foreach ($rows as $row) {
            DB::table('users')->updateOrInsert(
                ['id' => $row['id']],
                $row + [
                    /* ---- verificación & estado ---- */
                    'status'            => 1,
                    'ev'                => 1,
                    'sv'                => 1,
                    'tv'                => 0,
                    'ts'                => 0,
                    'kv'                => 1,
                    'reg_step'          => 1,
                    'ver_code'          => null,
                    'ver_code_send_at'  => null,
                    'ref_by'            => null,
                    /* ---- varios ---- */
                    'image'             => null,
                    'address'           => null,
                    'kyc_data'          => null,
                    'ban_reason'        => null,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]
            );
        }
    }
}
