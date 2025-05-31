<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransactionsSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('transactions')->insert([
                ['id'=>1,'user_id'=>2,'amount'=>25.00,'post_balance'=>75.00,'charge'=>0.00,'trx'=>'TRX123','trx_type'=>'-','remark'=>'bid','details'=>'Subtracted for bidding','created_at'=>now(),'updated_at'=>now()],
            ]);
    }
}
