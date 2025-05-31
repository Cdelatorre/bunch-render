<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GatewaysSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gateways')->insert([
            ['alias'=>'paypal','name'=>'PayPal','code'=>101,'parameters'=>json_encode(['client_id'=>'demo','secret'=>'demo']), 'status'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
