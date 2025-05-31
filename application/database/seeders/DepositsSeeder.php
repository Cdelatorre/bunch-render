<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepositsSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('deposits')->insert([
                ['id'=>1,'user_id'=>2,'method_code'=>1,'amount'=>100.00,'status'=>1,'trx'=>'DEP123','created_at'=>now(),'updated_at'=>now()],
            ]);
    }
}
