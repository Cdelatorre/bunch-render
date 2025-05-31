<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('reviews')->insert([
                ['id'=>1,'user_id'=>2,'product_id'=>1,'merchant_id'=>1,'rating'=>5,'message'=>'Great gym!','status'=>1,'created_at'=>now(),'updated_at'=>now()],
            ]);
    }
}
