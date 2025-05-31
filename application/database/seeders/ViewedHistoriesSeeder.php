<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ViewedHistoriesSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('viewed_histories')->insert([
                ['id'=>1,'user_id'=>2,'product_id'=>1,'ip'=>'127.0.0.1','created_at'=>now(),'updated_at'=>now()],
            ]);
    }
}
