<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('currencies')->insert([
            ['code'=>'EUR','name'=>'Euro','rate'=>1.000000,'created_at'=>now(),'updated_at'=>now()],
            ['code'=>'USD','name'=>'US Dollar','rate'=>1.100000,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
